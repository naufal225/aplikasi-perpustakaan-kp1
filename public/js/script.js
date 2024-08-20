document.addEventListener("DOMContentLoaded", function() {
    const input = document.querySelector('input[type="number"]');

input.addEventListener('keypress', function(e){
    if(e.key === 'e' || e.key === "E") {
        e.preventDefault();
    }
})
})