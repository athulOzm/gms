<?php //dd($get_allproducts); ?>
<canvas id="singelBarChart" id="productstatusresult" height="200"></canvas>
<script type="text/javascript">
    // single bar chart
<?php
$productsname = '';
foreach ($get_allproducts as $product) {
    $productsname .= '"' . $product->product_name . '",';
}
$productsname = rtrim($productsname, ',');
$salesquantity = '';
foreach ($get_allproducts as $product) {
    $salesquantity .= '"' . $product->salesquantity . '",';
}
$salesquantity = rtrim($salesquantity, ',');
?>
    var ctx = document.getElementById("singelBarChart");
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
//            labels: ["Sun", "Mon", "Tu", "Wed", "Th", "Fri", "Sat"],
            labels: [<?php echo $productsname; ?>],
            datasets: [
                {
                    label: "Sales Information",
                    data: [<?php echo $salesquantity; ?>],
                    borderColor: "rgba(55, 160, 0, 0.9)",
                    borderWidth: "0",
                    backgroundColor: "#328F00", //rgba(55, 160, 0, 0.5)"
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
            }
        }
    });
</script>