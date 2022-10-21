var collection;
var index;

function handlePHPResponse(response) {
  response = response["collection"];
  collection = response;
  setPokemonAttributes(collection[0]);
  index = 0;
}

function collectionScroll(direction) {
  index += direction;
  if (index < 0) {
    index += collection.length;
  } else if (index >= collection.length) {
    index %= collection.length;
  }
  setPokemonAttributes(collection[index]);
}

function jumpToScrollStart() {
  index = 0;
  setPokemonAttributes(collection[index]);
}

function jumpToScrollEnd() {
  index = collection.length - 1;
  setPokemonAttributes(collection[index]);
}

function setPokemonAttributes(pokemon) {
  let numhtml = document.getElementById("disp-number");
  let namehtml = document.getElementById("disp-name");
  let type1html = document.getElementById("disp-type1");
  let type2html = document.getElementById("disp-type2");
  let hphtml = document.getElementById("disp-hp");
  let attackhtml = document.getElementById("disp-attack");
  let defensehtml = document.getElementById("disp-defense");
  let spatkhtml = document.getElementById("disp-spatk");
  let spdefhtml = document.getElementById("disp-spdef");
  let speedhtml = document.getElementById("disp-speed");
  let generationhtml = document.getElementById("disp-generation");
  let legendaryhtml = document.getElementById("disp-legendary");
  let imghtml = document.getElementById("disp-pokemon-img");

  numhtml.innerHTML = pokemon.num;
  namehtml.innerHTML = pokemon.name;
  type1html.innerHTML = pokemon.type1;
  type2html.innerHTML = pokemon.type2;
  hphtml.innerHTML = pokemon.hp;
  hphtml.style.width = calcBarWidth(hphtml) + "px";
  attackhtml.innerHTML = pokemon.attack;
  attackhtml.style.width = calcBarWidth(attackhtml) + "px";
  defensehtml.innerHTML = pokemon.defense;
  defensehtml.style.width = calcBarWidth(defensehtml) + "px";
  spatkhtml.innerHTML = pokemon.spatk;
  spatkhtml.style.width = calcBarWidth(spatkhtml) + "px";
  spdefhtml.innerHTML = pokemon.spdef;
  spdefhtml.style.width = calcBarWidth(spdefhtml) + "px";
  speedhtml.innerHTML = pokemon.speed;
  speedhtml.style.width = calcBarWidth(speedhtml) + "px";
  generationhtml.innerHTML = pokemon.generation;
  legendaryhtml.innerHTML = pokemon.legendary;
  imghtml.src = "./data/images/" + pokemon.num + ".png";
}

function calcBarWidth(htmlelem) {
  return parseInt(200 * (parseInt(htmlelem.innerText) / 255));
}