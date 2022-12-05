const query_button = document.getElementById('query-button');
const insert_button = document.getElementById('insert-button');
const delete_button = document.getElementById('delete-button');
const query_form = document.getElementById('query-form');
const insert_form = document.getElementById('insert-form');
const query_submit = document.getElementById('query-submit');
const insert_submit = document.getElementById('insert-submit');

query_button.addEventListener('click', showQueryForm);
insert_button.addEventListener('click', showInsertForm);
query_submit.addEventListener('click', populateDataBrowser);
insert_submit.addEventListener('click', insertData);

async function handleFetch(url, form) {
  let formData = new FormData(form);
  let result = await fetch(url, {
    method:'POST',
    body: formData
  }).then(response => {
    return response.json();
  }).catch(err => {
    console.log(err); 
  });
  return result;
}

function showQueryForm() {
  insert_form.hidden = 1;
  query_form.hidden = 0;
}

function showInsertForm() {
  insert_form.hidden = 0;
  query_form.hidden = 1;
}

function insertData() {

}

async function populateDataBrowser() {
  let result = await handleFetch('./php/query.php', query_form);
  console.log(result);
}