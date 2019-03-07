(function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = '//static.criteo.net/js/ld/ld.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();

var realtor = document.getElementsByName("data[realtor]")[0];
var credit_score = document.getElementsByName("data[credit_score]")[0];
var military = document.getElementsByName("data[military]")[0];
var timeframe = document.getElementsByName("data[timeframe]")[0];
var city = document.getElementsByName("data[city]")[0];
var address = document.getElementsByName("data[address]")[0];
var zip_code = document.getElementsByName("data[zip_code]")[0];
var state = document.getElementsByName("data[state]")[0];
var first_name = document.getElementsByName("data[first_name]")[0];
var last_name = document.getElementsByName("data[last_name]")[0];
var email = document.getElementsByName("data[email]")[0];
var phone_home = document.getElementsByName("data[phone_home]")[0];
var first_homebuyer = document.getElementsByName("data[first_homebuyer]")[0];
var tmpformid = this.crm.sessionFormData().form_id,
tmpuuid = this.crm.sessionFormData().lead_id,
TMP_KEY_PREFIX_SALT = "crm.form_storage_key_",
tmpstorageKey = TMP_KEY_PREFIX_SALT + tmpuuid + "_" + tmpformid;

var page5Next = document.getElementsByName("data[page5Next]")[0];
var page6Next = document.getElementsByName("data[page6Next]")[0];
var page3Next = document.getElementsByName("data[page3Next]")[0];
var page9Next = document.getElementsByName("data[page9Next]")[0];
var page7Submit = document.getElementsByName("data[page7Submit]")[0];

page3Next.addEventListener("click", function(e) {
	sendcriterio();
});
page5Next.addEventListener("click", function(e) {
	sendcriterio();
});
page9Next.addEventListener("click", function(e) {
	sendcriterio();
});
page6Next.addEventListener("click", function(e) {
	presendcriterio();
});
page7Submit.addEventListener("click", function(e) {
	conversion(tmpstorageKey);
});


city.addEventListener("focusout", function(e) {
	console.log("city :"+city.value);
	if(city.value != "") {
		sendcriterio();
	}
});
first_name.addEventListener("focusout", function(e) {
	console.log("first_name :"+first_name.value);
	if(first_name.value != "") {
		presendcriterio();
	}
});
last_name.addEventListener("focusout", function(e) {
	console.log("last_name :"+last_name.value);
	if(last_name.value != "") {
		presendcriterio();
	}
});
email.addEventListener("focusout", function(e) {
	console.log("email :"+email.value);
	if(email.value != "") {
		presendcriterio();
	}
});
phone_home.addEventListener("focusout", function(e) {
	console.log("phone_home :"+phone_home.value);
	if(phone_home.value != "") {
		presendcriterio();
	}
});
address.addEventListener("focusout", function(e) {
	console.log("address :"+address.value);
	if(address.value != "") {
		presendcriterio();
	}
});
zip_code.addEventListener("focusout", function(e) {
	console.log("zip_code :"+zip_code.value);
	if(zip_code.value != "") {
		presendcriterio();
	}
});
state.addEventListener("change", function(e) {
	console.log("state :"+state.options[state.selectedIndex].value);
	if(state.options[state.selectedIndex].value != "") {
		sendcriterio();
	}
});
first_homebuyer.addEventListener("click", function(e) {
	console.log("first_homebuyer :"+first_homebuyer.value);
	sendcriterio();
});
credit_score.addEventListener("click", function(e) {
	console.log("credit_score :"+credit_score.value);
	sendcriterio();
});
realtor.addEventListener("click", function(e) {
	console.log("realtor :"+realtor.value);
	sendcriterio();
});
military.addEventListener("click", function(e) {
	console.log("military :"+military.value);
	sendcriterio();
});
timeframe.addEventListener("click", function(e) {
	console.log("timeframe :"+timeframe.value);
	sendcriterio();
});

function sendcriterio(){
	window.criteo_q.push(
		{ event: "manualFlush" },
		{ event: "setAccount", account: 52959 },
		{ event: "setData", ui_type: "buy" },
		{ event: "viewItem", item: "1" },
		{ event: "flushEvents"} 
	);
	console.log("Send to criterio");
}

function presendcriterio(){
	window.criteo_q.push(
		{ event: "manualFlush" },
		{ event: "setAccount", account: 52959 },
		{ event: "viewBasket", item: [ { id: "1", price: "0", quantity: 1 } ]} ,
		{ event: "flushEvents"}
	);
	console.log("Send to criterio");
}

function conversion(tmpstorageKey){
	var t = (JSON.parse(window.sessionStorage.getItem(tmpstorageKey)), {});
	window.criteo_q.push(
	{ event: "setAccount", account: 52959 },
	{ event: "setEmail", email: t.email },
	{ event: "trackTransaction", id: (new Date()).getTime() , deduplication: 1 or 0,
	item: [ { id: "1", price: "0", quantity: 1 } ] });
}