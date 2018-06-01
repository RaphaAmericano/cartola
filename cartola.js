(function( $ ){
    $.ajax({
        type: 'POST',
        dataType: 'text',
        url: 'consultas.php',
        data: 'action=1',
        success: function(response, xhr){
            //console.log(response);
            //console.log(xhr.responseText);
            graficoRodada(response);
        }, 
        error: function(err, err2, err3){
            //console.log(err+' '+err2+' '+err3);
        },
        complete:function(jqXHR, textStatus, errorThrown){
            // console.log(jqXHR);
            // console.log(textStatus);
            // console.log(errorThrown);
        }
    });

    function graficoRodada(data){
        
        var jsonData = JSON.parse(data);
        var numeroJogadores = jsonData.id_jogador.length;
        var rgbsBorder = randomRgb(numeroJogadores);
        var rgbsBackground = randomRgb(numeroJogadores, true);
        var rodadas = [];
        var sets1 = [];
        var sets2 = [];
        var pontuacoes = jsonData.pontos;
        var divisor = jsonData.pontos.length / jsonData.rodada.length; 
        //Array de rodadas pronto
        for(var i = 0; i < jsonData.rodada.length; i++){
            rodadas.push(parseInt(jsonData.rodada[i]));
        }


        for(var i = 0; i < jsonData.nome_equipe.length; i++){
            var pontos = [];
            var pontosTotais = [];

            for(var k =  0; k < jsonData.rodada.length ; k++){
                    
                pontos.push(parseFloat(pontuacoes[k]));
                if(k > 0 ){
                    
                    var sum = parseFloat(pontuacoes[k]) + parseFloat(pontosTotais[k-1]);
                    sum = Math.round(sum * 100 ) / 100;
                    pontosTotais.push(sum);
                   
                } else {
                pontosTotais.push(parseFloat(pontuacoes[k]));
                }
                
                if(pontuacoes.length > jsonData.rodada.length ){
                    pontuacoes.splice(0, 1);
                }  
                console.log(pontosTotais);
            }

            var dataset1 = {
                data: pontos,
                backgroundColor: rgbsBackground[i],
                borderColor: rgbsBorder[i],
                label: jsonData.nome_equipe[i]
            }
            var dataset2 = {
                data: pontosTotais,
                backgroundColor: rgbsBackground[i],
                borderColor: rgbsBorder[i],
                label: jsonData.nome_equipe[i]
            }
            sets1.push(dataset1);
            sets2.push(dataset2);
        }
    
        var objInstancia1 = {
            type: 'line',
            data: {
                labels: rodadas,
                datasets: sets1
                }
        };

        var objInstancia2 = {
            type: 'line',
            data: {
                labels: rodadas,
                datasets: sets2 
                }
        };

        var $canvas1 = document.getElementById("grafico1").getContext("2d");
        var graficoUm = new Chart($canvas1, objInstancia1);

         var $canvas2 = document.getElementById("grafico2").getContext("2d");
         var graficoDois = new Chart($canvas2, objInstancia2);
        //
        
    }

    function randomRgb(posicoes, background = false){
        var opacidade = "";
        if(background){
            opacidade = ",0.5"
        }

        arrayCores = [];
        for(var i = 0; i < posicoes; i++){
            var stringRgb;
            var numeroRgb = []
            for(var k = 0; k < 3; k++){
                numeroRgb.push(Math.floor((Math.random() * 255 ) + 1 ));
            }
            stringRgb = 'rgb('+numeroRgb[0]+','+numeroRgb[1]+','+numeroRgb[0]+opacidade+')';
            arrayCores.push(stringRgb);    
        }
        return arrayCores;
    }

}( jQuery ));