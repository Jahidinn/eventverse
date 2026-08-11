<?php

namespace App\Http\Controllers;
use App\Services\ReservationService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionParticipant;
use App\Models\TransactionForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class CheckoutController extends Controller
{
    public function __construct(
        protected ReservationService $reservationService,
        protected TransactionService $transactionService,
    ) {}

    public function create(string $reservationCode)
    {
        $checkout = $this->reservationService
            ->getCheckoutData($reservationCode);

        if (isset($checkout['redirect'])) {
            return redirect($checkout['redirect']);
        }

        return view('transaction.checkout', $checkout);
    }

    public function validateCheckout(Request $request)
    {
        $request->validate([
            // 'event_id' => ['required', 'exists:events,id'],
            // 'ticket_id' => ['required', 'exists:tickets,id'],
            'reservation_code' => ['required', 'exists:reservations,reservation_code'],

            'buyer.name' => ['required', 'string', 'max:255'],
            'buyer.email' => ['required', 'email:rfc,dns'],
            'buyer.phone' => [
                'required',
                'regex:/^\+62(8[1-9][0-9]{7,11})$/',
            ],

            'participants' => ['required', 'array', 'min:1'],
        ],[
            'event_id.required' => 'Event tidak ditemukan.',
            'ticket_id.required' => 'Tiket tidak ditemukan.',

            'buyer.name.required' => 'Nama pembeli wajib diisi.',
            'buyer.email.required' => 'Email pembeli wajib diisi.',
            'buyer.email.email' => 'Format email pembeli tidak valid.',
            'buyer.phone.required' => 'Nomor HP pembeli wajib diisi.',
            'buyer.phone.regex' => 'Nomor HP pembeli tidak valid.',

            'participants.required' => 'Minimal harus ada 1 peserta.',
            'participants.array' => 'Data peserta tidak valid.',
            'participants.min' => 'Minimal harus ada 1 peserta.',
        ]);

        $summary = $this->transactionService->validateCheckout($request);

        return response()->json([
            'success' => true,
            'summary' => $summary,
        ]);
    }

    public function store(Request $request)
    {
        $transaction = $this->transactionService->checkout($request);

        return response()->json([
            'success' => true,
            'redirect_url' => route(
                'transaction.show',
                $transaction->transaction_code
            ),
        ]);
    }


    public function cleanupSandbox()
    {
        DB::transaction(function () {

            $transactions = Transaction::where('environment', 'sandbox')
                ->whereDate('created_at', today())
                ->get();

            foreach ($transactions as $transaction) {

                $participants = TransactionParticipant::where(
                    'transaction_id',
                    $transaction->id
                )->get();

                foreach ($participants as $participant) {

                    $forms = TransactionForm::where(
                        'participant_id',
                        $participant->id
                    )->get();

                    foreach ($forms as $form) {

                        if (!empty($form->form_value)) {
                            Storage::disk('public')->delete($form->form_value);
                        }

                        $form->delete();
                    }

                    $participant->delete();
                }

                $transaction->delete();
            }

        });

        return response()->json([
            'success' => true,
            'message' => 'Sandbox transactions deleted successfully.',
        ]);
    }

}