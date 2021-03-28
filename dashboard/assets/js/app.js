let usdBTC = document.getElementById("usd_btc");
let ngnBTC = document.getElementById("ngn_btc");
let usdETH = document.getElementById("usd_eth");
let ngnETH = document.getElementById("ngn_eth");
let amt = document.getElementById("amt");
let coinAmount = document.getElementById("coinAmount");
let amount = document.getElementById("amount");
let coin_amount = document.getElementById("coin_amount");
let selectCoin = document.getElementById("selectCoin");
let coinAmt = document.getElementById("coinAmt");
let naira = document.getElementById("naira");

// logic
let myHeaders = new Headers();
myHeaders.append("X-CoinAPI-Key", "D38917A3-3CCD-4F23-B56C-5433A9F55C01");

selectCoin.onchange = () => {
	let newToken = 0

	let nairarate = () => {
		if(selectCoin.value == "BTC"){
			getExchangeRate(
				'NGN', 
				(result) => naira.value = coinAmt.value * result.rate),
				() => {}
		}else {
			getExchangeRate(
				'NGN', 
				() => {},
				(result) => naira.value = coinAmt.value * result.rate)
		}
	}

	coinAmt.oninput = () => {
		clearTimeout(newToken)
		newToken = setTimeout(nairarate, 1000)
	}
	nairarate()
}

(async function generateExchange() {
	await getExchangeRate(
		'USD', 
		(result) => {
			usdBTC.innerText = result.rate.toLocaleString()
		},

		(result) => {
			usdETH.innerText = result.rate.toLocaleString()
		}
	)

	await getExchangeRate(
		'NGN', 
		(result) => {
			ngnBTC.innerText = result.rate.toLocaleString()
		},

		(result) => {
			ngnETH.innerText = result.rate.toLocaleString()
		}
	)
})()


let token = 0;

amt.oninput = () => {
	clearTimeout(token);
	token = setTimeout( () => getExchangeRate(
		'NGN', 
		(result) => coinAmount.value = amt.value / result.rate,
		() => {}
		), 1000);
}

let settoken = 0;

amount.oninput = () => {
	clearTimeout(settoken);
	settoken = setTimeout( () => getExchangeRate(
		'NGN', 
		() => {},
		(result) => coin_amount.value = amount.value / result.rate
		), 1000);
}



// const getRate = (ratesArray, currency) => {
// 	const rateObj = ratesArray.filter(Object=>Object.asset_id_quote == currency);
// 	return rateObj.rate;
// }


async function getExchangeRate(url, btcCallback, ethCallback) {
	apiBtcURL = "https://rest.coinapi.io/v1/exchangerate/BTC/" + url;
	apiEthURL = "https://rest.coinapi.io/v1/exchangerate/ETH/" + url;

	let requestOptions = {
	    method: 'GET',
	    headers: myHeaders,
	    redirect: 'follow'
	};

	const btcResponse = await fetch(apiBtcURL, requestOptions)
	    btcResponse.json()
	    .then(
			btcCallback
	    )
	    .catch(error => console.log('error', error.message));

	const ethResponse = await fetch(apiEthURL, requestOptions)
	    ethResponse.json()
	    .then(
			ethCallback
	    )
	    .catch(error => console.log('error', error.message));
};

// 1. fetch the btc rate
// 2. check the currency chosen
// 3. filter by the currency
// 4. multiply by the input value



	    	// amount.onkeyup = () => {
				// const currencyRate = getRate(result.rates, coinOption.value)
		    	// coinBTC.value = amount.value / result.rate;
	    	// }

			
	    	// amount.onkeyup = () => {
		    	// coinETH.value = amount.value / result.rate;
	    	// }