class Persona {
    #edad;
    constructor(nombre, edad, genero) {
        this.nombre = nombre;
        this.#edad = edad;
        this.genero = genero;
    }
    saludo() {
        console.log(`Hola soy ${this.nombre} y tengo ${this.#edad} años.`);
    }
    mayordeedad(){
        if(this.#edad>17){
            console.log(`${this.nombre} es mayor de edad`);
        } else{
            console.log(`${this.nombre} es menor de edad`);
        }

    }
}
module.exports=Persona;