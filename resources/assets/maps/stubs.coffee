module.exports =
	tile: ->
		id: Math.floor(Math.random() * 100000)
		name: 'Area Name'
		box:
			top: '20%'
			left: '30%'
			width: '5%'
			height: '10%'
		connections: []

	region: ->
		id:  Math.floor(Math.random() * 100000)
		name: 'Region Name'
		bonus: 0
		tiles: []
