// script.js
document.getElementById('captureButton').addEventListener('click', function() {
    // Check if the user's webcam is available
    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                // Create a video element to display the webcam stream
                var video = document.createElement('video');
                video.srcObject = stream;
                video.play();

                // Wait for the video to start playing
                video.addEventListener('canplay', function() {
                    // Create a canvas element to capture the image
                    var canvas = document.createElement('canvas');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    var context = canvas.getContext('2d');
                    context.drawImage(video, 0, 0, canvas.width, canvas.height);

                    // Get the image data as a base64 string
                    var imageData = canvas.toDataURL('image/png');

                    // Send the image data to the server
                    sendImageData(imageData);
                });
            })
            .catch(function(error) {
                console.log('Error accessing webcam:', error);
            });
    } else {
        console.log('Webcam not supported in this browser.');
    }
});

function sendImageData(imageData) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'index.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Redirect the user to the thank you page
            window.location.href = 'thankyou.php';
        } else {
            console.log('Error: ' + xhr.status);
        }
    };
    xhr.send('imageData=' + encodeURIComponent(imageData));
}