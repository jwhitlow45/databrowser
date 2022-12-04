const query_button = document.getElementById('query-button');
const insert_button = document.getElementById('insert-button');
const delete_button = document.getElementById('delete-button');
const query_form = document.getElementById('query-form');
const insert_form = document.getElementById('insert-form');

query_button.addEventListener('click', showQueryForm);
insert_button.addEventListener('click', showInsertForm);

function showQueryForm() {
  insert_form.hidden = 1;
  query_form.hidden = 0;
}

function showInsertForm() {
  insert_form.hidden = 0;
  query_form.hidden = 1;
}