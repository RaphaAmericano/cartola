(function( $ ){
    $.ajax({
        type: 'POST',
        dataType: 'html',
        url: 'consultas.php',
        data: 'action=1',
        success: function(response){
            console.log(response);
            graficoRodada(response);
        }, 
        error: function(err, err2, err3){
            console.log(err+' '+err2+' '+err3);
        },
        complete:function(arg){
            console.log(arg);
        }
    });

    function graficoRodada(data){
        
        jsonData = JSON.parse(data);
        var rgbs = randomRgb(3);
        var rodadas = [];
        var pontos = [];
        var c = 0;
        for(var i = 0; i < jsonData.pontos.length; i++){
            var pontosJogador = [];
            
            pontosJogador.push(parseFloat(jsonData.pontos[i]));
            c++;
            console.log(pontosJogador);
            if(jsonData.pontos[i+3] == NaN || jsonData.pontos[i+3] == undefined ){ 
                pontos.push(pontosJogador);
                continue; 
            }
            if( i+2 <= jsonData.pontos.length  ){
            
                
                
                pontosJogador.push(parseFloat(jsonData.pontos[i+3]));
                pontos.push(pontosJogador);
                c++;
            }
            if(c == jsonData.pontos.length){
                break;
            }

            
        }            

        for( var i = 0; i < jsonData.nome_jogador.length; i++ ){
            rodadas.push(
                    {
                        label: 'Equipe:'+jsonData.nome_equipe[i]+' - Jogador:'+jsonData.nome_jogador[i],
                        lineTension: 0,
                        borderColor: rgbs[i],
                        data: pontos[i]
                    }
                );
            }

        console.log(pontos);
        console.log(rodadas);
        
        var ctx = document.getElementById("grafico1").getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: jsonData.rodada,
                datasets: rodadas 
            }
        });
    }

    function graficoLideranca(data, options){
        var ctx = document.getElementById("grafico2").getContext("2d");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: data,
            options: options
        });
    }
    
    function randomRgb(posicoes){
        
        arrayCores = [];
        for(var i = 0; i < posicoes; i++){
            var stringRgb;
            var numeroRgb = []
            for(var k = 0; k < 3; k++){
                numeroRgb.push(Math.floor((Math.random() * 255 ) + 1 ));
            }
            stringRgb = 'rgb('+numeroRgb[0]+','+numeroRgb[1]+','+numeroRgb[0]+')';
            arrayCores.push(stringRgb);    
        }
        return arrayCores;
    }

}( jQuery ));