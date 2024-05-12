document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('button[name="clock_in"], button[name="clock_out"]').forEach(function(button) {
        button.addEventListener('click', function() {
            var popup = document.getElementById('clockPopup');
            var text = document.getElementById('clockPopupText');

            text.innerHTML = 'Clocked ' + (button.getAttribute('name') === 'clock_in' ? 'in' : 'out');
            popup.style.display = 'block';

            setTimeout(function() {
                popup.style.display = 'none';
            }, 2000);
        });
    });
});