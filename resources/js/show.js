window.deleteWish = (wish_id) => {
    axios.delete('/wish/'+wish_id)
	.then(
		(response) => {
			window.location.reload();
		},
		(error) => {
			alert(error.response.data.message);
		}
	)
}

window.purchaseWish = (wish_id) => {
    axios.patch('/wish/'+wish_id+'/purchase')
	.then(
		(response) => {
			window.location.reload();
		},
		(error) => {
			alert(error.response.data.message);
		}
	)
}

window.unpurchaseWish = (wish_id) => {
    axios.patch('/wish/'+wish_id+'/unpurchase')
	.then(
		(response) => {
			window.location.reload();
		},
		(error) => {
			alert(error.response.data.message);
		}
	)
}