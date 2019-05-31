
const websocketPort = wsPort ? wsPort : 8080;
const conn = new WebSocket('ws://localhost:' + websocketPort),
  idMessages = 'chatMessages';
conn.onopen = function(e) {
  console.log("Connection established!");
};

conn.onmessage = function(e) {
  document.getElementById(idMessages).value = `${websocketUser}: ${e.data}\n` + document.getElementById(idMessages).value;

  const $el = $('li.messages-menu ul.menu li:first').clone();
  $el.find('p').text(e.data);
  $el.find('h4').text(websocketUser);
  $el.prependTo('li.messages-menu ul.menu');

  const cnt = $('li.messages-menu ul.menu li').length - 1;
  $('li.messages-menu span.label-success').text(cnt);
  $('li.messages-menu li.header').text('You have ' + cnt + ' messages');
};

function textMessageSend() {
  const btn = document.getElementById('chatSendMessageBtn');
  const textField = document.getElementById('chatSendMessageField');

  btn.addEventListener('click', (e) => {
    conn.send(textField.value);
    textField.value = '';
  });
}

textMessageSend();