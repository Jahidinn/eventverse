<script>
    $(function () {

        renderParticipants(1);

    });


    /*
    |--------------------------------------------------------------------------
    | Render Participant
    |--------------------------------------------------------------------------
    */

    function renderParticipants(qty) {

    const participantContainer = $('#participantContainer');
    const current = participantContainer.find('.participant-card').length;

    if (qty > current) {

        const template = document.getElementById('participantTemplate');

        for (let i = current; i < qty; i++) {

            const fragment = template.content.cloneNode(true);

            fragment.querySelectorAll('*').forEach(el => {

                if (el.name)
                    el.name = el.name.replace(/__INDEX__/g, i);

                if (el.id)
                    el.id = el.id.replace(/__INDEX__/g, i);

                if (el.htmlFor)
                    el.htmlFor = el.htmlFor.replace(/__INDEX__/g, i);

            });

            participantContainer[0].appendChild(fragment);

        }

    } else if (qty < current) {

        participantContainer.find('.participant-card').slice(qty).remove();

    }

    participantContainer.find('.participant-card').each(function(index){

        $(this).find('.participant-number').text(index + 1);

    });

    initParticipantComponents();

}
</script>