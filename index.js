import pokemon from './data/pokemondb.json' assert {type:'json'};

class PokemonDB {

  constructor(collection) {
    this.collection = collection;
  }

  findNumber(num) {
    let newColl = new Array();
    for (let poke of this.collection) {
      if (poke.Num == num) {
        newColl.push(poke);
      }
    }
    return new PokemonDB(newColl);
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

  findStat(stat, min, max) {
    let newColl = new Array();
    for (let poke of this.collection) {
      if (poke[stat] >= min && poke[stat] <= max) {
        newColl.push(poke);
      }
    }
    return new PokemonDB(newColl);
  }

  findGeneration(gen) {
    let newColl = new Array();
    for (let poke of this.collection) {
      if (poke.Generation == gen) {
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

console.log(db.findNumber(10));
