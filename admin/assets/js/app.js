let form = document.getElementById("coin-form");
let coinOption = document.getElementById("coin-options");
let amount = document.getElementById("coin-amount");
let coinBTC = document.getElementById("coin-btc");
let coinETH = document.getElementById("coin-eth");

// logic
let myHeaders = new Headers();
myHeaders.append("X-CoinAPI-Key", "D38917A3-3CCD-4F23-B56C-5433A9F55C01");

coinOption.onchange = () => {
	apiBtcURL = "https://rest.coinapi.io/v1/exchangerate/BTC/" + coinOption.value;
	apiEthURL = "https://rest.coinapi.io/v1/exchangerate/ETH/" + coinOption.value;

	let requestOptions = {
	    method: 'GET',
	    headers: myHeaders,
	    redirect: 'follow'
	};

	fetch(apiBtcURL, requestOptions)
	    .then(response => response.json())
	    .then(result => {
	    	amount.onkeyup = () => {
		    	coinBTC.value = result.rate * amount.value;
	    	}
	    })
	    .catch(error => console.log('error', error));
};