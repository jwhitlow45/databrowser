var collection;
var index;

// form handler
const form = document.getElementById("query-form");
const query = document.getElementById("query");
const insert = document.getElementById("insert");
query.addEventListener('click', function(event) {
  event.preventDefault();

  // format form data
  const formData = new FormData(form);
  queryDB(formData);
});
insert.addEventListener('click', function(event) {
  event.preventDefault();
  
  // format form data
  const formData = new FormData(form);
  insertDB(formData);
});

async function queryDB(formData) {
  fetch('query.php', {
    method: 'POST',
    body: formData
  })
  .then((response) => {
    if (!response.ok) {
      throw response;
    }
    return response.json();
  }).then((json) => {
    handleQueryResponse(json);
  }).catch((err) => {
    console.error(err);
  });
}

async function insertDB(formData) {
  fetch('insert.php', {
    method: 'POST',
    body: formData
  })
  .then((response) => {
    if (!response.ok) {
      throw response;
    }
    return response.json();
  }).then((json) => {
    console.log(json);
    handleInsertResponse(json);
  }).catch((err) => {
    console.error(err);
  });
}

function handleQueryResponse(response) {
  response = response["collection"];
  collection = response;
  setPokemonAttributes(collection[0]);
  index = 0;
}

function handleInsertResponse(response) {

}

// stat html elements
const numhtml = document.getElementById("disp-number");
const namehtml = document.getElementById("disp-name");
const type1html = document.getElementById("disp-type1");
const type2html = document.getElementById("disp-type2");
const hphtml = document.getElementById("disp-hp");
const attackhtml = document.getElementById("disp-attack");
const defensehtml = document.getElementById("disp-defense");
const spatkhtml = document.getElementById("disp-spatk");
const spdefhtml = document.getElementById("disp-spdef");
const speedhtml = document.getElementById("disp-speed");
const generationhtml = document.getElementById("disp-generation");
const legendaryhtml = document.getElementById("disp-legendary");
const imghtml = document.getElementById("disp-pokemon-img");

// event listeners for scroll buttons
const scroll_start = document.getElementById("scroll-start");
scroll_start.addEventListener('click', function() {jumpToScrollStart()});
const scroll_prev = document.getElementById("scroll-prev");
scroll_prev.addEventListener('click', function() {collectionScroll(-1)});
const scroll_next = document.getElementById("scroll-next");
scroll_next.addEventListener('click', function() {collectionScroll(1)});
const scroll_end = document.getElementById("scroll-end");
scroll_end.addEventListener('click', function() {jumpToScrollEnd()});

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

function resetPokemonAttributes() {
  numhtml.innerHTML = "???";
  namehtml.innerHTML = "???";
  type1html.innerHTML = "???";
  type2html.innerHTML = "???";
  hphtml.innerHTML = "???";
  hphtml.style.width = "100px"
  attackhtml.innerHTML = "???";
  attackhtml.style.width = "100px"
  defensehtml.innerHTML = "???";
  defensehtml.style.width = "100px"
  spatkhtml.innerHTML = "???";
  spatkhtml.style.width = "100px"
  spdefhtml.innerHTML = "???";
  spdefhtml.style.width = "100px"
  speedhtml.innerHTML = "???";
  speedhtml.style.width = "100px"
  generationhtml.innerHTML = "???";
  legendaryhtml.innerHTML = "???";
  imghtml.src = "./data/images/placeholder.png";
}

function setPokemonAttributes(pokemon) {
  if (collection.length < 1) {
    resetPokemonAttributes();
    return;
  }

  function calcBarWidth(htmlelem) {
    return parseInt(100 * (parseInt(htmlelem.innerText) / 255));
  }

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