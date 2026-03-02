import React from 'react';
import { createRoot } from 'react-dom/client';
import RotatingText from './RotatingText';

document.addEventListener('DOMContentLoaded', () => {
    const container = document.getElementById('rotating-text-root');

    if (!container) return;

    const root = createRoot(container);
    root.render(
        <RotatingText
            texts={['élet', 'élmény', 'segítség', 'neked!']} 
            
            mainClassName="bg-green-500 text-white px-4 py-1 sm:px-5 sm:py-2 rounded-xl overflow-hidden flex justify-center items-center"
            
            staggerFrom="last"
            initial={{ y: "100%" }}
            animate={{ y: 0 }}
            exit={{ y: "-120%" }}
            staggerDuration={0.025}
            splitLevelClassName="overflow-hidden pb-0.5 sm:pb-1 md:pb-1"
            transition={{ type: "spring", damping: 30, stiffness: 400 }}
            rotationInterval={2000} 
        />
    );
});