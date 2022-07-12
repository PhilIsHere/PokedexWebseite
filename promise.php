<?php
?>

<div id="start" data-alert="irgendwas" >
<span>
    <h1>Hallo ich bin die Überschrift und werde durch die divPromise() verändert</h1>
</span>
</div>
<div>
    <h3 id="counter">Ich werde durch divCounter zufällig eingefärbt</h3>
</div>
<script>

    function promiseBeispiel1() {
        //Drei Stati: Pending, Rejected/Resolved
        return new Promise((resolve, reject) => {
            setTimeout(()=>{
                resolve('promise wurde aufgelöst');
            }, 1000);
        });
    }

    let promise = promiseBeispiel1();
    let result;
    promise.then((result)=> {
        console.log(result);
    });
    promise.catch((result) => {
        console.error(result);
    });

    function divPromise(){
        return new Promise((resolve, reject) =>{
            setTimeout(()=>{
                resolve('Die Überscheift ist jetzt grün');
            }, 3000);
        })
    }
    let divElement = divPromise();
    let divResult;
    divElement.then((divResult)=>{
        document.getElementById('start').style.color = "green";
        console.log(divResult);
    });
    divElement.catch((divResult)=>{
        document.getElementById('start').style.color = "red";
        console.log(divResult);
    });
    async function colourDivCounter() {
        return new Promise((resolve, reject)=>{
            let number =  Math.floor(Math.random() * 10) + 1;
            console.log(number + ' is the value of number')
            if(number > 0 && number < 3){
                resolve(number + ' unter drei');
            }
            else if (number > 2 && number < 6){
                resolve(number + ' höher 2 unter 6');
            }
            else{
                reject(number + ' höher als 6');
            }
        })
    }
    async function arbeitArbeit(){
        try{
            let colourPromise = colourDivCounter();
            colourPromise.then((colourResult) =>{
                console.log(colourResult);
                document.getElementById("counter").style.color='green';
            });
            colourPromise.catch((colourResult)=>{
                console.log(colourResult);
                document.getElementById("counter").style.color='red';
            });
        }catch (e) {
            console.log(e);
        }
    }
    arbeitArbeit();


    function test2() {
        console.log('was anderes');
    }
    test2();
    let div = document.querySelector('#start');
</script>


