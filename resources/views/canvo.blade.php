<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">

    <title>Canvas</title>
    <style>
        html {
            height: 100%;
        }

        body {
            /*display: flex;*/
            justify-content: center;
            /*align-items: center;*/
            height: 100%;
            margin: 0;
            padding: 0;
        }

        header {
            position: relative;
            width: 100vw;
            height: 30vw;
            overflow: hidden;
        }

        #canvas {
            position: absolute;
            top: 0;
            left: 0;
            /*background: #d1ffff;*/
            background: #C1604F;
            width: 100%;
            /*height: 480px;*/
        }
        
        .page-title {
            font-size: 6em;
            position: relative;
            /*width: 550px;*/
            /*width: 100%;*/
            margin: 0;
            padding: 50px 0 0 50px;
            max-width: 100%;
            /*text-align: center;*/
            /*font-family: $script;*/
            /*background: $brand_primary;*/
            color: #f88008;
            font-family: 'Lobster';
            text-shadow: #171717 1px 1px,#171717 0px 0px,#171717 1px 1px,#171717 2px 2px,#171717 3px 3px,#171717 4px 4px,#171717 5px 5px,#171717 6px 6px,#171717 7px 7px,#171717 8px 8px,#171717 9px 9px,#171717 10px 10px,#171717 11px 11px,#171717 12px 12px,#171717 13px 13px,#171717 14px 14px,#171717 15px 15px,#171717 16px 16px,#171717 17px 17px,#171717 18px 18px,#171717 19px 19px,#171717 20px 20px,#171717 21px 21px,#171717 22px 22px,#171717 23px 23px,#171717 24px 24px,#171717 25px 25px,#171717 26px 26px,#171717 27px 27px,#171717 28px 28px,#171717 29px 29px;
        }
    </style>
</head>
<body>
<header>
    <canvas id="canvas"></canvas>
    {{--<h1 class="page-title">--}}
        {{--<span>Good Gifts</span><br>--}}
        {{--<span>for Guys.</span>--}}
    {{--</h1>--}}
</header>

<script>
    let sunburst = {
        canvas: document.querySelector('#canvas'),
        ctx: null,
        centerPoint: {x: null, y: null},
        base_width: null,
        base_height: null,
        image_width: null,
        image_height: null,

        init() {
            const width = window.innerWidth;
            this.base_width = width * 3;
            this.base_height = (width * 3) * .3;
            this.ctx = this.canvas.getContext('2d');
            this.centerPoint.x = width < 500 ? this.base_width / 2 : 500;
            this.centerPoint.y = width < 500 ? this.base_height / 2 : 400;
            this.canvas.width = this.base_width;
            this.canvas.height = this.base_width;

            this.image_width = this.base_width < 500 ? this.base_width * .7 : this.base_width / 3;
            this.image_height =this.image_width / 1.7;
        },

        drawRay() {

            const line_length = this.base_width;
            const cpx1 = this.centerPoint.x + (line_length * .1);
            const cpx2 = this.centerPoint.x + (line_length * .4);
            const ray_base = this.base_width / 12;
            const y_dev = ray_base / (150/90);
            this.ctx.beginPath();
            this.ctx.moveTo(this.centerPoint.x, this.centerPoint.y);

            this.ctx.bezierCurveTo(cpx1, this.centerPoint.y - y_dev, cpx2, (this.centerPoint.y - ray_base/2) + y_dev, this.base_width*2, this.centerPoint.y - (ray_base/2));

            this.ctx.lineTo(this.base_width*2, this.centerPoint.y + (ray_base/2));

            this.ctx.bezierCurveTo(cpx2, (this.centerPoint.y + ray_base/2) + y_dev, cpx1, this.centerPoint.y - y_dev, this.centerPoint.x, this.centerPoint.y);

            let gradient = this.ctx.createLinearGradient(this.centerPoint.x, this.centerPoint.y, line_length, this.centerPoint.y);
            gradient.addColorStop(0, '#C1604F');
            gradient.addColorStop(.4, '#ffcd55');
            gradient.addColorStop(.6, '#ffb33b');
            gradient.addColorStop(.8, '#ff9a22');
            gradient.addColorStop(1, '#f88008');
//            gradient.addColorStop(.25, '#a5ec8e');
//            gradient.addColorStop(.75, '#8cd375');
//            gradient.addColorStop(1, '#72b95b');

            this.ctx.fillStyle = gradient;
            this.ctx.fill();
//            this.ctx.beginPath();
//            this.ctx.moveTo(this.centerPoint.x, this.centerPoint.y);
//            this.ctx.lineTo(this.base_width, this.centerPoint.y);
//            this.ctx.lineWidth = "20px";
//            this.ctx.strokeStyle = "#0000FF";
//            this.ctx.stroke();
        },

        rotateCanvas() {
            this.ctx.translate(this.centerPoint.x, this.centerPoint.y);
            this.ctx.rotate(7.5 * Math.PI / 180);
            this.ctx.translate( -this.centerPoint.x, -this.centerPoint.y);
        },

        drawLogo() {
            const image = new Image;


            image.onload = () => this.placeLogo(image);
            image.src = '/images/goodforguys.png';
        },

        placeLogo(image) {
            this.ctx.translate(this.centerPoint.x, this.centerPoint.y);
            this.ctx.rotate(-37.5 * Math.PI / 180);
            this.ctx.translate( -this.centerPoint.x, -this.centerPoint.y);

            this.ctx.drawImage(image, this.centerPoint.x - (this.image_width/2.5), this.centerPoint.y - (this.image_height/2.5), this.image_width, this.image_height);
        }

    }
    sunburst.init();
    for(let x = 0; x < 53; x++) {
        sunburst.drawRay();
        sunburst.rotateCanvas();
    }
    sunburst.drawRay();
    sunburst.drawLogo();
</script>
</body>
</html>
