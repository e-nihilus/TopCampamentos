// Dashboard - eCommerce
//----------------------

if(jQuery("#thisYearRevenue").length)
   (function(window, document, $) {

      // Line chart with color shadow: Revenue for 2018 Chart
      var thisYearctx = document.getElementById("thisYearRevenue").getContext("2d");
      var lastYearctx = document.getElementById("lastYearRevenue").getContext("2d");

      // Chart shadow LineAlt
      Chart.defaults.LineAlt = Chart.defaults.line;
      var draw = Chart.controllers.line.prototype.draw;
      var custom = Chart.controllers.line.extend({
         draw: function() {
            draw.apply(this, arguments);
            var ctx = this.chart.chart.ctx;
            var _stroke = ctx.stroke;
            ctx.stroke = function() {
               ctx.save();
               ctx.shadowColor = "rgba(156, 46, 157,0.5)";
               ctx.shadowBlur = 20;
               ctx.shadowOffsetX = 2;
               ctx.shadowOffsetY = 20;
               _stroke.apply(this, arguments);
               ctx.restore();
            };
         }
      });
      Chart.controllers.LineAlt = custom;

      // Chart shadow LineAlt2
      Chart.defaults.LineAlt2 = Chart.defaults.line;
      var draw = Chart.controllers.line.prototype.draw;
      var custom = Chart.controllers.line.extend({
         draw: function() {
            draw.apply(this, arguments);
            var ctx = this.chart.chart.ctx;
            var _stroke = ctx.stroke;
            ctx.stroke = function() {
               ctx.save();
               _stroke.apply(this, arguments);
               ctx.restore();
            };
         }
      });
      Chart.controllers.LineAlt2 = custom;

      var thisYearData = {
         labels: ["January", "February", "March", "April", "May", "June"],
         datasets: [
            {
               label: "This year",
               data: [45, 62, 15, 78, 58, 98],
               fill: false,
               pointRadius: 2.2,
               pointBorderWidth: 1,
               borderColor: "#9C2E9D",
               borderWidth: 5,
               pointBorderColor: "#9C2E9D",
               pointHighlightFill: "#9C2E9D",
               pointHoverBackgroundColor: "#9C2E9D",
               pointHoverBorderWidth: 2
            }
         ]
      };

      var lastYearData = {
         labels: ["January", "February", "March", "April", "May", "June"],
         datasets: [
            {
               label: "Last year dataset",
               data: [12, 6, 25, 58, 38, 68],
               borderDash: [15, 5],
               fill: false,
               pointRadius: 0,
               pointBorderWidth: 0,
               borderColor: "#E4E4E4",
               borderWidth: 5
            }
         ]
      };
      var thisYearOption = {
         responsive: true,
         maintainAspectRatio: true,
         datasetStrokeWidth: 3,
         pointDotStrokeWidth: 4,
         tooltipFillColor: "rgba(0,0,0,0.6)",
         legend: {
            display: false,
            position: "bottom"
         },
         hover: {
            mode: "label"
         },
         scales: {
            xAxes: [
               {
                  display: false
               }
            ],
            yAxes: [
               {
                  ticks: {
                     padding: 10,
                     stepSize: 20,
                     max: 100,
                     min: 0,
                     fontColor: "#9e9e9e"
                  },
                  gridLines: {
                     display: true,
                     drawBorder: false,
                     lineWidth: 1,
                     zeroLineColor: "#e5e5e5"
                  }
               }
            ]
         },
         title: {
            display: false,
            fontColor: "#FFF",
            fullWidth: false,
            fontSize: 40,
            text: "82%"
         }
      };
      var lastYearOption = {
         responsive: true,
         maintainAspectRatio: true,
         datasetStrokeWidth: 3,
         pointDotStrokeWidth: 4,
         tooltipFillColor: "rgba(0,0,0,0.6)",
         legend: {
            display: false,
            position: "bottom"
         },
         hover: {
            mode: "label"
         },
         scales: {
            xAxes: [
               {
                  display: false
               }
            ],
            yAxes: [
               {
                  ticks: {
                     padding: 10,
                     stepSize: 20,
                     max: 100,
                     min: 0
                  },
                  gridLines: {
                     display: true,
                     drawBorder: false,
                     lineWidth: 1
                  }
               }
            ]
         },
         title: {
            display: false,
            fontColor: "#FFF",
            fullWidth: false,
            fontSize: 40,
            text: "82%"
         }
      };

      var thisYearChart = new Chart(thisYearctx, {
         type: "LineAlt",
         data: thisYearData,
         options: thisYearOption
      });

      var lastYearChart = new Chart(lastYearctx, {
         type: "LineAlt2",
         data: lastYearData,
         options: lastYearOption
      });

      //  Monthly Earning Chart : Line chart with shadow
      //---------------------------------------------------

      // Chart shadow
      Chart.defaults.earnningLineShadow = Chart.defaults.line;
      var draw = Chart.controllers.line.prototype.draw;
      var custom = Chart.controllers.line.extend({
         draw: function() {
            draw.apply(this, arguments);
            var ctx = this.chart.chart.ctx;
            var _stroke = ctx.stroke;
            ctx.stroke = function() {
               ctx.save();
               ctx.shadowColor = "rgba(255, 111, 0, 0.3";
               ctx.shadowBlur = 14;
               ctx.shadowOffsetX = 2;
               ctx.shadowOffsetY = 16;
               _stroke.apply(this, arguments);
               ctx.restore();
            };
         }
      });
      Chart.controllers.earnningLineShadow = custom;

      //Chart gradient strock
      var Earningctx = document.getElementById("monthlyEarning").getContext("2d");
      var gradientStroke = Earningctx.createLinearGradient(500, 0, 0, 200);
      gradientStroke.addColorStop(0, "#ffca28");
      gradientStroke.addColorStop(1, "#ff6f00");
      //Chart data
      var earningChartData = {
         labels: ["1", "2", "3", "4", "5", "6", "7", "8", "8", "8", "8", "8", "8", "8"],
         datasets: [
            {
               label: "This year dataset",
               lineTension: 0,
               fill: false,
               pointRadius: 0,
               pointBorderWidth: 0,
               borderColor: gradientStroke,
               borderWidth: 3,
               data: [50, 40, 30, 55, 50, 90, 40, 50, 40, 70, 55, 80, 50, 55]
            }
         ]
      };

      var earningChartOptions = {
         responsive: true,
         maintainAspectRatio: true,
         datasetStrokeWidth: 3,
         pointDotStrokeWidth: 4,
         tooltipFillColor: "rgba(0,0,0,0.6)",
         layout: {
            padding: {
               left: 50,
               right: 0,
               top: 0,
               bottom: 0
            }
         },
         legend: {
            display: false,
            position: "bottom"
         },
         hover: {
            mode: "label"
         },
         scales: {
            xAxes: [
               {
                  display: false
               }
            ],
            yAxes: [
               {
                  display: false
               }
            ]
         },
         title: {
            display: false,
            fontColor: "#FFF",
            fullWidth: false,
            fontSize: 40,
            text: "82%"
         }
      };

      var MonthlyEarningChart = new Chart(Earningctx, {
         type: "earnningLineShadow",
         data: earningChartData,
         options: earningChartOptions
      });
   })(window, document, jQuery);
