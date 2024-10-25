const drawSpline = async () => {
    const x1 = parseFloat(document.getElementById('x1').value);
    const y1 = parseFloat(document.getElementById('y1').value);
    const x2 = parseFloat(document.getElementById('x2').value);
    const y2 = parseFloat(document.getElementById('y2').value);
    const x3 = parseFloat(document.getElementById('x3').value);
    const y3 = parseFloat(document.getElementById('y3').value);

    if (!isNaN(x1) && !isNaN(y1) && !isNaN(x2) && !isNaN(y2) && !isNaN(x3) && !isNaN(y3)) {
        const response = await fetch(
            /api/index.php?method=spline&x1=${x1}&y1=${y1}&x2=${x2}&y2=${y2}&x3=${x3}&y3=${y3}
        );
        const answer = await response.json();

        if (answer?.result === 'ok') {
            drawSplineGraph(answer.splinePoints);
        } else {
            console.error("im broken");
        }
    }
};

const drawSplineGraph = (splinePoints) => {
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#F08080';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    // оси
    ctx.strokeStyle = '#DC143C';
    ctx.moveTo(0, canvas.height / 2);
    ctx.lineTo(canvas.width, canvas.height / 2);
    ctx.moveTo(canvas.width / 2, 0);
    ctx.lineTo(canvas.width / 2, canvas.height);
    ctx.stroke();

    
    ctx.strokeStyle = '#8B0000';
    ctx.beginPath();
    for (let i = 0; i < splinePoints.length; i++) {
        const x = splinePoints[i].x * canvas.width;
        const y = canvas.height / 2 - splinePoints[i].y * canvas.height;
        if (i === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }
    }
    ctx.stroke();
};


window.onload = function () {
    document.getElementById('butSpl').addEventListener('click', drawSpline);
}