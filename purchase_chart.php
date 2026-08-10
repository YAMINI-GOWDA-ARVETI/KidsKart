<script>

fetch("sales_chart.php")

.then(res=>res.json())

.then(data=>{

let month=[];

let total=[];

data.forEach(item=>{

month.push(item.month);

total.push(item.total);

});

new Chart(document.getElementById("salesChart"),{

type:"line",

data:{

labels:month,

datasets:[{

label:"Sales",

data:total,

fill:false,

borderWidth:3

}]

}

});

});

</script>