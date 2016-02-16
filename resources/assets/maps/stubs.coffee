module.exports =
	tile: () ->
		id: Math.floor(Math.random() * 10000)
		name: 'Name'
		box:
			top: '20%'
			left: '30%'
			width: '5%'
			height: '10%'
		connections: []
