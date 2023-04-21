<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
</script>
<script>
    $(document).ready(function() {

        $('#month').change(
            function() {
                var formData = new FormData();

                // Append the movie data to the form data
                formData.append("Month", $(this).val() + "-01");

                $.ajax({
                    url: '/?api/transaction/getrevenue',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data, status) {
                        console.log(data.data);
                        myChart.data.labels = data.data[0];
                        myChart.data.datasets[0].data = data.data[1];
                        myChart.update();

                        var totalRevenue = 0;
                        for (var i = 0; i < myChart.data.datasets[0].data.length; i++) {
                            totalRevenue +=  parseInt(myChart.data.datasets[0].data[i]);
                        }

                        $('#total_revenue').text(totalRevenue.toLocaleString() + " VNĐ")

                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    },
                    dataType: 'json'
                });

            }
        )
        // Tạo biểu đồ
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Doanh thu (VNĐ)',
                    data: [],
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                return value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    })
</script>