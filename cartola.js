(function( $ ){
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: 'consultas.php',
        data: 'action=1',
        success: function(response){
            //console.log(response);
            //console.warn(xhr.responseText);
            graficoRodada(response);
        }, 
        error: function(err, err2, err3){
            //console.log(err+' '+err2+' '+err3);
        },
        complete:function(jqXHR, textStatus, errorThrown){
            console.log(jqXHR);
        }
    });

    // $.ajax({
    //     type: 'POST',
    //     dataType: 'html',
    //     url: 'consultas.php',
    //     data: 'action=2',
    //     success: function(response){
    //         //console.log(response);
    //         graficoLideranca(response);
    //     }, 
    //     error: function(err, err2, err3){
    //         //console.log(err+' '+err2+' '+err3);
    //     },
    //     complete:function(arg){
    //         //console.log(arg);
    //     }
    // });


    function graficoRodada(data){
        console.log(data);
        var jsonData = JSON.parse(data);
        var rgbs = randomRgb(3);
        var rodadas = [];
        var sets = [];
        var pontuacoes = jsonData.pontos;
        var divisor = jsonData.pontos.length / jsonData.rodada.length; 
        //Array de rodadas pronto
        for(var i = 0; i < jsonData.rodada.length; i++){
            rodadas.push(parseInt(jsonData.rodada[i]));
        }


        for(var i = 0; i < jsonData.nome_equipe.length; i++){
            var pontos = [];
            console.log(pontuacoes);
//            for(var k = ( 0 * i * jsonData.rodada.length) ; k < jsonData.rodada.length * ( i + 1 ); k++){
            for(var k =  0; k < jsonData.rodada.length ; k++){
               
                pontos.push(parseFloat(pontuacoes[k]));
                if(pontuacoes.length > 7 ){
                    pontuacoes.splice(0, 1);
                }  
            }
            var dataset = {
                data: pontos,
                label: jsonData.nome_equipe[i]
            }
            sets.push(dataset);
            console.log(dataset);
        }
        console.log(sets);

        var objInstancia = {
            type: 'line',
            data: {
                labels: rodadas,
    //            labels: jsonData.rodada,
                datasets: sets 
                }
        };
        //console.log(objInstancia);
        var $canvas1 = document.getElementById("grafico1").getContext("2d");
        var graficoUm = new Chart($canvas1, objInstancia);

        var graficoTeste = new Chart($canvas3, {
            type: 'line',
            data: {
                labels: [ 1, 2, 3, 4, 5, 6, 7],
                datasets: [{
                    data:[95.87, 79.09, 78.32, 76.03, 97.56, 72.84, 58.46],
                    label: 'marcel'
                },
                {
                    data:[84.57, 107.09, 74.89, 56.72, 94.11, 81.22, 76.46],
                    label: 'valdir'
                },
                {
                    data:[75.86, 40.65, 47.75, 54.74, 97.97, 116.82, 83.54],
                    label: 'raphael'
                }]
                
            }
        });
        
    }

    function graficoLideranca(data){

        jsonData = JSON.parse(data);
        var rgbs = randomRgb(3);
        var pontuacoesTotais = [];
        var rodadas = [];
        
        
        for(var i = 0; i < jsonData.pontos.length; i++){
            rodadas.push(i);
            pontuacoesTotais.push(
                {
                    label: 'Equipe:'+jsonData.nome_equipe[i],
                    lineTension: 0,
                    borderColor: rgbs[i],
                    data: parseFloat(jsonData.pontos[i])
                }
            );
        }
    
        // console.log(pontuacoesTotais);
        // console.log(rodadas);
        var $canvas2 = document.getElementById("grafico2").getContext("2d");
        var graficoDo = new Chart($canvas, {
            type: 'line',
            data: {
                labels: rodadas,
                datasets:[{
                    labels: "rodada",
                    datasets:pontuacoesTotais
                }]
            }
        });
        //console.log(graficoDois.data);
        //Grafico model abaixo
        
        var graficoDois = new Chart($canvas2, {
            type: 'line',
            data: {
                labels: [ 1, 2, 3, 4, 5, 6, 7],
                datasets: [{
                    data:[95.87, 174.96, 253.28, 329.31, 426.87, 499.72, 558.18],
                    label: 'marcel'
                },
                {
                    data:[84.57, 191.66, 266.55, 323.27, 417.38, 498.6, 575.06],
                    label: 'valdir'
                },
                {
                    data:[75.86, 116.5, 164.25, 218.99, 316.96, 433.78, 517.32],
                    label: 'raphael'
                }]
                
            }
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