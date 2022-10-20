import pokemon from './data/pokemondb.json' assert {type:'json'};

class PokemonDB {

  constructor(collection) {
    this.collection = collection;
  }

  findName(name) {
    let newColl = new Array();

    for (let poke of this.collection) {
      if (poke.Name.toLowerCase().includes(name.toLowerCase())) {
        newColl.push(poke);
      }
    }

    return new PokemonDB(newColl);
  }

  findType(type) {
    let newColl = new Array();

    for (let poke of this.collection) {
      if (poke.Type1.toLowerCase() == type.toLowerCase()) {
        newColl.push(poke);
      } else if (poke.Type2.toLowerCase() == type.toLowerCase()) {
        newColl.push(poke);
      }
    }

    return new PokemonDB(newColl);
  }

  findLegendary(legendary) {
    let newColl = new Array();

    for (let poke of this.collection) {
      if (poke.Legendary.toLowerCase() == legendary.toLowerCase()) {
        newColl.push(poke);
      }
    }

    return new PokemonDB(newColl);
  }
}

let db = new PokemonDB(pokemon);

console.log(db.findName("char"));
