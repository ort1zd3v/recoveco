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
                formatter: "{b}: {@2012} ({d}%)",
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

    function fetchData(url, containerId, titleText) {
        $.ajax({
            url: $('meta[name="app-url"]').attr("content") + url,
            type: "GET",
            dataType: "json",
            success: function (response) {
                console.log(response); // Haz algo con los datos recibidos
                createChart(containerId, titleText, response);
            },
            error: function (xhr, status, error) {
                console.log("Error:", error);
            },
        });
    }

    fetchData(
        "/report_by_payment_types/getChart",
        "chart",
        "Estatus de Reportes"
    );
   
    
});
