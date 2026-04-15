window.beginReviewWriting = function(restaurantId, csrfToken = '') {
    let container = document.getElementById('container');
    let htmlContent = `
    <div class="comment-wall">
        <div class="comment-card bg-gray-500 dark:bg-zinc-950">
            <form action="/api/restaurants/${restaurantId}/reviews" method="POST">
                <input type="hidden" name="_token" value="${csrfToken}">
                
                <div class="text-center flex flex-row-reverse justify-center">
                    <input type="radio" name="rating" value="5" class="hidden peer" id="rate-5">
                    <label for="rate-5" class="peer-hover:text-[#fd4] peer-checked:text-[#fd4] text-[40px] text-[#444] p-2 cursor-pointer transition-all duration-200 ease-in">★</label>

                    <input type="radio" name="rating" value="4" class="hidden peer" id="rate-4">
                    <label for="rate-4" class="peer-hover:text-[#fd4] peer-checked:text-[#fd4] text-[40px] text-[#444] p-2 cursor-pointer transition-all duration-200 ease-in">★</label>

                    <input type="radio" name="rating" value="3" class="hidden peer" id="rate-3">
                    <label for="rate-3" class="peer-hover:text-[#fd4] peer-checked:text-[#fd4] text-[40px] text-[#444] p-2 cursor-pointer transition-all duration-200 ease-in">★</label>

                    <input type="radio" name="rating" value="2" class="hidden peer" id="rate-2">
                    <label for="rate-2" class="peer-hover:text-[#fd4] peer-checked:text-[#fd4] text-[40px] text-[#444] p-2 cursor-pointer transition-all duration-200 ease-in">★</label>

                    <input type="radio" name="rating" value="1" class="hidden peer" id="rate-1">
                    <label for="rate-1" class="peer-hover:text-[#fd4] peer-checked:text-[#fd4] text-[40px] text-[#444] p-2 cursor-pointer transition-all duration-200 ease-in">★</label>
                </div>
                
                <textarea name="review" placeholder="Írd le a véleményedet!" class="rounded text-center focus:text-left p-2 w-full h-64 text-black dark:text-white bg-white dark:bg-gray-500 mt-4"></textarea><br>
                <button type="submit" class="btn-new-review mt-3">Közzététel!</button>
            </form>
        </div>
    </div>
    `;
    container.innerHTML = htmlContent;
}