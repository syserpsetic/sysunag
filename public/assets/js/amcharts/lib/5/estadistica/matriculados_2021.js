$(function () {
    "use strict";

    var colors = {
        // primary: "#6571ff",
        primary: "#1ba333",
        secondary: "#7987a1",
        success: "#05a34a",
        info: "#66d1d1",
        // warning: "#fbbc06",
        warning: "#ffcc00",
        danger: "#ff3366",
        light: "#e9ecef",
        dark: "#060c17",
        muted: "#7987a1",
        gridBorder: "rgba(77, 138, 240, .15)",
        bodyColor: "#000",
        cardBg: "#fff",
    };

    var fontFamily = "'Roboto', Helvetica, sans-serif";

    // Apex Bar chart end
    //Finaliza conteo_empleados_general
    // Create root
    var root = am5.Root.new("chartdiv_2021");

    // Set themes
    root.setThemes([am5themes_Animated.new(root)]);

    // Create chart
    var chart = root.container.children.push(
        am5map.MapChart.new(root, {
            panX: "rotateX",
            panY: "none",
            projection: am5map.geoMercator(), // Mejor proyección para Honduras
            layout: root.horizontalLayout,
        })
    );

    // Create polygon series
    var polygonSeries = chart.series.push(
        am5map.MapPolygonSeries.new(root, {
            geoJSON: am5geodata_hondurasHigh, // ← Mapa de Honduras
            valueField: "value",
            calculateAggregates: true,
        })
    );

    // Tooltip
    polygonSeries.mapPolygons.template.setAll({
        tooltipText: "{name}: {value}",
    });

    // Color por valor
    polygonSeries.set("heatRules", [
        {
            target: polygonSeries.mapPolygons.template,
            dataField: "value",
            min: am5.color(0x1ba333), // #1ba333
            max: am5.color(0x135423), // #135423
            key: "fill",
        },
    ]);

    // Mostrar valor al pasar el mouse
    polygonSeries.mapPolygons.template.events.on("pointerover", function (ev) {
        heatLegend.showValue(ev.target.dataItem.get("value"));
    });

    polygonSeries.data.setAll([{"id" : "EXTR", "value" : 4}, {"id" : "HN-AT", "value" : 51}, {"id" : "HN-CH", "value" : 133}, {"id" : "HN-CL", "value" : 56}, {"id" : "HN-CM", "value" : 166}, {"id" : "HN-CP", "value" : 65}, {"id" : "HN-CR", "value" : 64}, {"id" : "HN-EP", "value" : 178}, {"id" : "HN-FM", "value" : 245}, {"id" : "HN-GD", "value" : 21}, {"id" : "HN-IB", "value" : 0}, {"id" : "HN-IN", "value" : 103}, {"id" : "HN-LM", "value" : 138}, {"id" : "HN-LP", "value" : 90}, {"id" : "HN-OC", "value" : 58}, {"id" : "HN-OL", "value" : 338}, {"id" : "HN-SB", "value" : 36}, {"id" : "HN-VA", "value" : 18}, {"id" : "HN-YO", "value" : 87}]);

    // Heat legend
    var heatLegend = chart.children.push(
        am5.HeatLegend.new(root, {
            orientation: "vertical",
            startColor: am5.color(0x1ba333),
            endColor: am5.color(0x135423),
            startText: "Menor",
            endText: "Mayor",
            stepCount: 5,
        })
    );

    // Labels de la leyenda
    heatLegend.startLabel.setAll({
        fontSize: 12,
        fill: heatLegend.get("startColor"),
    });

    heatLegend.endLabel.setAll({
        fontSize: 12,
        fill: heatLegend.get("endColor"),
    });

    // Actualizar valores de leyenda
    polygonSeries.events.on("datavalidated", function () {
        heatLegend.set("startValue", polygonSeries.getPrivate("valueLow"));
        heatLegend.set("endValue", polygonSeries.getPrivate("valueHigh"));

        // Calcular total
        var total = polygonSeries.dataItems.reduce(function (sum, di) {
            return sum + (di.get("value") || 0);
        }, 0);

        // Label del total usando un container flotante
        if (!root.totalLabel) {
            root.totalLabel = root.container.children.push(
                am5.Label.new(root, {
                    text: "TOTAL: " + total,
                    x: 20, // píxeles desde la izquierda
                    y: 20, // píxeles desde arriba
                    fontSize: 12,
                    fontWeight: "bold",
                    fill: am5.color(0x000000),
                })
            );
        } else {
            root.totalLabel.set("text", "TOTAL: " + total);
        }
    });
});
