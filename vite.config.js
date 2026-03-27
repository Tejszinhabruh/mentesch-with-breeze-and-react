import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js','resources/css/rotate.css','resources/js/rotate.jsx','resources/css/commentwall.css','resources/js/colorscheme.js','resources/js/createReview.js','resources/js/editAllergenlist.js','resources/js/getAllergens.js','resources/js/getRestaurants.js'],
            refresh: true,
        }),
    ],
});
