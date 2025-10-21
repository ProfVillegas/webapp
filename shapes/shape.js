class Shape{
    constructor(x,y,color){
        this.color=color;
        this.x=x;
        this.y=y;
    }
    area(){
        console.log("No se tiene la información necesaria para calcular el área");
    }
    posicion(){
        console.log(`Se encentra en la posición ${this.x}, ${this.y}.`);
    }
}
class Circle extends Shape{
    constructor(r,x,y,color){
        super(x,y,color);
        this.r=r;// r es el Radio
    }
    area(){
        let a=0;
        a=this.r*this.r*Math.PI;
        console.log(`El área es: ${a}`);
    }
}
class Triangle extends Shape{
    constructor(b,h,x,y,color){
        super(x,y,color);
        this.b=b;
        this.h=h;
    }
    area(){
        let a=0;
        a=(this.b*this.h)/2;
        console.log(`El área es: ${a}`);
    }
}
class Square extends Shape{
    constructor(l,x,y,color){
        super(x,y,color);
        this.l=l;
    }
    area(){
        let a=0;
        a=this.l*this.l;
        console.log(`El área es: ${a}`);
    }
}