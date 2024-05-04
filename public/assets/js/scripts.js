document
  .getElementById("letterForm")
  .addEventListener("submit", function (event) {
    event.preventDefault();

    var date = document.getElementById("date").value;
    var sender = document.getElementById("sender").value;
    var recipient = document.getElementById("recipient").value;
    var subject = document.getElementById("subject").value;
    var body = document.getElementById("body").value;
    var number = document.getElementById("num").value;
    var pav = document.getElementById("pav").value;


    document.querySelector(".number").textContent = ` ${number} : شماره`;
    document.querySelector(".date").textContent = ` ${date} : تاریخ`;
    document.querySelector(".pav").textContent = ` ${pav} : پیوست`;


  });
