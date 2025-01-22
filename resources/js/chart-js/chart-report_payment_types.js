$(function () {
    function createChart(containerId, titleText, data) {
        var dom = document.getElementById(containerId);
        var myChart = echarts.init(dom, null, {
            renderer: "canvas",
            useDirtyRect: false,
        });
        myChart.showLoading();
		
        var option = {
            title: {
                text: titleText,
                left: "center",
            },
            legend: {
                top: "bottom",
                formatter: "{name}",
            },
            label: {
				formatter: function(params) {
					return params.name + ' - ' + params.data.user + ': $' + params.value.toLocaleString();
				}
            },
			tooltip: {
				valueFormatter: (value) => '$' + value.toLocaleString()
			},
			
            series: [
                {
                    name: "Access From",
                    type: "pie",
                    radius: "50%",
                    data: data,
                    emphasis: {
                        itemStyle: {
                            shadowBlur: 10,
                            shadowOffsetX: 0,
                            shadowColor: "rgba(0, 0, 0, 0.5)",
                        },
                    },
                },
            ],
        };

        if (option && typeof option === "object") {
            myChart.hideLoading();
            myChart.setOption(option);
        }

        window.addEventListener("resize", myChart.resize);
    }

    function fetchData(url, containerId, titleText, data = null) {
        $.ajax({
            url: $('meta[name="app-url"]').attr("content") + url,
            type: "GET",
            dataType: "json",
			data: data,
            success: function (response) {
                console.log(response); // Haz algo con los datos recibidos
                createChart(containerId, titleText, response);
            },
            error: function (xhr, status, error) {
                console.log("Error:", error);
            },
        });
    }

	$("#btn-search-report_by_payment_types").on('click', () => {
		const data = {
			"initial_date" : $("#initial_date").val(),
			"final_date" : $("#final_date").val()
		}

		fetchData(
			"/report_by_payment_types/getChart",
			"chart",
			"Reporte por tipos de pago",
			data
		);
	})

	$("#btn-clear-report_by_payment_types").on('click', () => {
		fetchData(
			"/report_by_payment_types/getChart",
			"chart",
			"Reporte por tipos de pago",
		);
	})

    fetchData(
        "/report_by_payment_types/getChart",
        "chart",
        "Reporte por tipos de pago"
    );
   
    
});
