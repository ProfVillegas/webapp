class Vehiculo {
  constructor(marca, modelo) {
    this.marca = marca;
    this.modelo = modelo;
  }

  info() {
    console.log(`Marca: ${this.marca}, Modelo: ${this.modelo}`);
  }
}

class Moto extends Vehiculo {
  constructor(ci, ma, mo) {
    super(ma, mo);
    this.cilindro = ci;
  }

  infoCompleta() {
    this.info();
    console.log(`Cilindro: ${this.cilindro}`);
  }
}

class Auto extends Vehiculo {
  constructor(cf, ma, mo) {
    super(ma, mo);
    this.caballosFuerza = cf;
  }

  infoCompleta() {
    this.info();
    console.log(`Caballos de Fuerza: ${this.caballosFuerza}`);
  }
}

const miMoto = new Moto(500,'Honda', 'CBR500');
const miAuto = new Auto(400,'Toyota', 'Supra');
miMoto.infoCompleta();
miAuto.infoCompleta();

const readline = require('readline');

const rl = readline.createInterface({
  input: process.stdin,
  output: process.stdout
});

rl.question('Proporcione marca del la moto: ', (marca) => {
  miMoto.marca = marca;
  rl.question('Proporcione modelo del la moto: ', (modelo) => {
    miMoto.modelo = modelo;
    rl.question('Proporcione cilindro del la moto: ', (cilindro) => {
      miMoto.cilindro = cilindro;
      miMoto.infoCompleta(); // Mueve la impresión aquí para que use los datos ingresados
      rl.close();
    });
  });
});
