<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peys App</title>
</head>

<body>

    <div style="padding-bottom: 50px;">
        <h2>Peys App</h2>

        <label for="imageSize">Select Image Size:</label>
        <input type="range" id="imageSize" min="0" max="100" value="10" step="10">
        <span id="sizeValue">10</span><br><br>

        <label for="borderColor">Select Border Color:</label>
        <input type="color" id="borderColor" value="#000000"><br><br>

        <button id="processButton">Process</button>
    </div>

    <img id="image" src="yuki.png" alt="Image" style="width: 200px; height: 200px; border: 3.5px solid #000000;" />

    <script>
    const image = document.getElementById('image');
    const imageSize = document.getElementById('imageSize');
    const borderColor = document.getElementById('borderColor');
    const sizeValue = document.getElementById('sizeValue');
    const processButton = document.getElementById('processButton');

    let appliedSize = 200; // Initial size in pixels

    // Update the displayed slider value but do not change the image
    imageSize.addEventListener('input', () => {
        sizeValue.textContent = imageSize.value; // Show the range slider value (10-100)
    });

    // Apply changes only when the "Process" button is pressed
    processButton.addEventListener('click', () => {
        const sliderValue = imageSize.value; // Slider value (10-100)
        const color = borderColor.value;

        // Map slider value (10-100) to image size in pixels (100px - 500px)
        appliedSize = (sliderValue - 10) * 4 + 100; // Linear mapping
        image.style.width = appliedSize + 'px';
        image.style.height = appliedSize + 'px';
        image.style.borderColor = color;
    });
    </script>

</body>

</html>