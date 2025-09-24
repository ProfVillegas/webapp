class Animal {
  sonido() {
    console.log('Sonido genérico');
  }
}

class Perro extends Animal {
  sonido() {
    console.log('Woof, Woof');
  }
}

class Gato extends Animal {
  sonido() {
    console.log('Meow, Meow');
  }
}

class Lobo extends Animal {
  sonido() {
    console.log('Auu, Auu');
  }
}

const animales = [new Animal(), new Perro(), new Gato(), new Lobo()];

animales.forEach(animal => {
  animal.sonido();
});

// Cambiamos el primer elemento del arreglo por un Lobo.
// Esto demuestra polimorfismo: aunque animales[0] era un Animal genérico,
// ahora es un Lobo y al llamar animal.sonido() ejecuta el método de Lobo.
animales[0] = new Lobo();

animales.forEach(animal => {
  animal.sonido();
});


