window.beginReviewWriting = function(restaurantId, csrfToken = '', reviewId = null, existingComment = '', existingRating = 0) {
    let container = document.getElementById('container');
    
    const actionUrl = reviewId ? `/reviews/${reviewId}` : `/restaurants/${restaurantId}/reviews`;
    
    let htmlContent = `
    <div class="comment-wall" id="review-writing-area">
        <div class="comment-card bg-gray-500 dark:bg-zinc-900 border-2 ${reviewId ? 'border-emerald-500' : 'border-transparent'}">
            
            <form action="${actionUrl}" method="POST">
                <input type="hidden" name="_token" value="${csrfToken}">
                ${reviewId ? `<input type="hidden" name="_method" value="PUT">` : ''}
                
                <div class="text-center flex flex-row-reverse justify-center">
                    ${[5, 4, 3, 2, 1].map(num => `
                        <input type="radio" name="rating" value="${num}" class="hidden peer" id="rate-${num}" ${num == existingRating ? 'checked' : ''}>
                        <label for="rate-${num}" class="peer-hover:text-[#fd4] peer-checked:text-[#fd4] text-[40px] text-[#444] p-2 cursor-pointer transition-all duration-200 ease-in">★</label>
                    `).join('')}
                </div>
                
                <textarea name="comment" placeholder="Írd le a véleményedet!" class="rounded text-center focus:text-left p-2 w-full h-64 text-black dark:text-white bg-white dark:bg-gray-500 mt-4">${existingComment}</textarea><br>
                
                <div class="flex gap-2">
                    <button type="submit" class="btn-new-review mt-3 flex-1">${reviewId ? 'Módosítás mentése' : 'Közzététel!'}</button>
                    ${reviewId ? `<button type="button" onclick="document.getElementById('review-writing-area').remove()" class="mt-3 p-2 bg-red-500 text-white rounded">Mégse</button>` : ''}
                </div>
            </form>
        </div>
    </div>
    `;
    
    container.innerHTML = htmlContent;

    document.getElementById('review-writing-area').scrollIntoView({ behavior: 'smooth', block: 'center' });
}