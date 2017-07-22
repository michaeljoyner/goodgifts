import Color from "color";

export default class Sunburst {

    constructor(settings) {
        this.logo_src = settings.logo_src;
        this.canvas = settings.canvas;
        this.ctx = this.canvas.getContext('2d');
        this.ctx.save();
        this.color = Color(settings.colour);

    }

    draw({centerPoint, base_width, base_height, image_width, image_position_factor}) {
        this.canvas.width = base_width;
        this.canvas.height = base_width;
        this.clearCanvas();

        this.centerPoint = centerPoint;
        this.base_width = base_width;
        this.base_height = base_height;
        this.image_width = image_width;
        this.image_position_factor = image_position_factor;

        this.ctx.restore();

        this.drawSunburst();
    }

    clearCanvas() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }

    drawRay() {
        const line_length = this.base_width;
        const cpx1 = this.centerPoint.x + (line_length * .1);
        const cpx2 = this.centerPoint.x + (line_length * .4);
        const ray_base = this.base_width / 15;
        const y_dev = ray_base / (150/90);

        this.ctx.beginPath();
        this.ctx.moveTo(this.centerPoint.x, this.centerPoint.y);

        this.ctx.bezierCurveTo(cpx1, this.centerPoint.y - y_dev, cpx2, (this.centerPoint.y - ray_base/2) + y_dev, this.base_width*2, this.centerPoint.y - (ray_base/2));

        this.ctx.lineTo(this.base_width*2, this.centerPoint.y + (ray_base/2));

        this.ctx.bezierCurveTo(cpx2, (this.centerPoint.y + ray_base/2) + y_dev, cpx1, this.centerPoint.y - y_dev, this.centerPoint.x, this.centerPoint.y);

        let gradient = this.ctx.createLinearGradient(this.centerPoint.x, this.centerPoint.y, line_length, this.centerPoint.y);
        gradient.addColorStop(0, '#C1604F');
        gradient.addColorStop(.4, this.color.lighten(.35).hex());
        gradient.addColorStop(.6, this.color.lighten(.25).hex());
        gradient.addColorStop(.8, this.color.lighten(.15).hex());
        gradient.addColorStop(1, this.color.hex());

        this.ctx.fillStyle = gradient;
        this.ctx.fill();
    }

    rotateCanvas() {
        this.ctx.translate(this.centerPoint.x, this.centerPoint.y);
        this.ctx.rotate(7.5 * Math.PI / 180);
        this.ctx.translate( -this.centerPoint.x, -this.centerPoint.y);
    }

    drawLogo() {
        const image = new Image;
        image.onload = () => this.placeLogo(image);
        image.src = this.logo_src;
    }

    placeLogo(image) {
        this.ctx.translate(this.centerPoint.x, this.centerPoint.y);
        this.ctx.rotate(-37.5 * Math.PI / 180);
        this.ctx.translate( -this.centerPoint.x, -this.centerPoint.y);

        this.ctx.drawImage(image, ...this.imagePlacements());
    }

    drawSunburst() {
        for(let x = 0; x < 53; x++) {
            this.drawRay();
            this.rotateCanvas();
        }
        this.drawRay();
        this.drawLogo();
    }

    imagePlacements() {
        return [
            this.centerPoint.x - (this.image_width / this.image_position_factor),
            this.centerPoint.y - ((this.image_width / 1.7) / this.image_position_factor),
            this.image_width,
            this.image_width / 1.7
        ];
    }
}