window.beginReviewWriting = function(){
                let container = document.getElementById('container');
                let htmlContent = `
                <div class="comment-wall">
                <div class="comment-card bg-gray-500 dark:bg-zinc-950">
                <form action="review.store" method="POST">
                <textarea name="review" placeholder="Írd le a véleményedet!" class="rounded text-center focus:text-left p-2 w-full h-64 text-black dark:text-white bg-white dark:bg-gray-500"></textarea><br>
                <button type="submit" class="btn-new-review mt-3">Közzététel!</button>
                </form>
                </div>
                </div>
                `;
                container.innerHTML = htmlContent;
}