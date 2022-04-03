window.addEventListener('DOMContentLoaded', (event) => {
    let xhr = new XMLHttpRequest()

    const containers = document.querySelectorAll('.js-vote-arrows');

    containers.forEach(container => {
        const elements = container.querySelectorAll('a');
        elements.forEach(element => {
            element.addEventListener('click',(function (e) {
                e.preventDefault();

                function updateVote () {
                    let total_vote = container.querySelector('.js-vote-total');
                    let vote = JSON.parse(this.responseText);
                    total_vote.innerHTML = vote.votes;
                }

                let link = e.currentTarget;
                let url = '/comments/10/vote/'+link.dataset.direction;
                xhr.onload = updateVote;
                xhr.open('POST', url, true)
                xhr.send();

            }))
        })
    })

});