<?php

namespace App\Services;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ComboChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\VAxis;
use App\Repository\ArticleRepository;

class Chart
{
    const ANIMATION_STARTUP = true;
    const ANIMATION_DURATION = 1000;
    const CHART_AREA_HEIGHT = '80%';
    const CHART_AREA_WIDTH = '80%';

    private $chartData;
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function nbrArticle() {

        /******** *********/
        /** Diagramme camember */
        /*
        $pieChart = new PieChart();


        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['author 1', $this->articleRepository->count(['author' => 73]) ],
                ['author 2', $this->articleRepository->count(['author' => 72]) ],
            ]
        );

        return $pieChart;
        */

        $col = new ColumnChart();
        $col->getData()->setArrayToDataTable(
            [
                ['AQ', 'NA'],
                [['v' => [8, 0, 0], 'f' => '8 am'],  1, '1', 0.25, '0.2'],
                [['v' => [9, 0, 0], 'f' => '9 am'],  2, '2',  0.5, '0.5'],
                [['v' => [10, 0, 0], 'f' => '10 am'], 3, '3',    1,  '1'],
                [['v' => [11, 0, 0], 'f' => '11 am'], 4, '4', 2.25,  '2'],
                [['v' => [12, 0, 0], 'f' => '12 am'], 5, '5', 2.25,  '2'],
                [['v' => [13, 0, 0], 'f' => '1 pm'],  6, '6',    3,  '3'],
                [['v' => [14, 0, 0], 'f' => '2 pm'],  7, '7', 3.25,  '3'],
                [['v' => [15, 0, 0], 'f' => '3 pm'],  8, '8',    5,  '5'],
                [['v' => [16, 0, 0], 'f' => '4 pm'],  9, '9',  6.5,  '6'],
                [['v' => [17, 0, 0], 'f' => '5 pm'], 10, '10',  10, '10']
            ]
        );
        $col->getOptions()
            ->setTitle('Taux de réussite / échec')
            ->setWidth(900)
            ->setHeight(500);
        $col->getOptions()
            ->getAnnotations()
            ->setAlwaysOutside(true)
            ->getTextStyle()
            ->setAuraColor('none')
            ->setFontSize(14)
            ->setColor('#000');
        $col->getOptions()
            ->getHAxis()
            ->setFormat('h:mm a')
            ->setTitle('Time of Day')
            ->getViewWindow()
            ->setMin([7, 30, 0])
            ->setMax([17, 30, 0]);
        $col->getOptions()
            ->getVAxis()
            ->setTitle('Rating (scale of 1-10)');
        return $col;
    }
}