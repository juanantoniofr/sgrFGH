<html lang="es-ES">
	<head>
		<meta charset="UTF-8" />
		<style>
			
			table {
				margin-top:10px;
				padding:20px;
				width: 100%;
				text-align:center;
			}
			
			td {
				 border:1px solid #aaa;
			}
			
			th {
				font-size:1.2em;
				padding:10px 20px;
					
			}
			
			td.columnaHora {
				font-size:0.9em;
			}

			div#info-filtros {
				text-align: center;
			}
			div#info-filtros h1, div#info-filtros h2{
				display: block;
			}

		</style>
	</head>
	<body>
		{{ $infoFiltros or '' }}
		{{ $horario or '' }}
	</body>
</html>';