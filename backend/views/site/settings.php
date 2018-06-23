<?php


use app\models\MembershipFunctions;
use backend\components\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $articles[] Articles */
/* @var $mf MembershipFunctions */
/* @var $coords MembershipFunctions->coords */
/* @var $defaultCoords MembershipFunctions->coords */

$this->title = 'Новости';

$this->registerJs(<<<JS
window.coords = {$coords};
window.defaultCoords = {$defaultCoords};

var setInputs = function() {
     var form = $('#mf-form');
        
        // First mf
        form.find('.form-control')[0].value = coords[0].vq[1].x;
        
        form.find('.form-control')[1].value = coords[0].q[0].x;
        form.find('.form-control')[2].value = coords[0].q[2].x;
        
        form.find('.form-control')[3].value = coords[0].l[0].x;
        form.find('.form-control')[4].value = coords[0].l[2].x;
        
        form.find('.form-control')[5].value = coords[0].vl[0].x;
        
        // Second mf
        form.find('.form-control')[6].value = coords[1].ns[1].x;

        form.find('.form-control')[7].value = coords[1].ls[0].x;
        form.find('.form-control')[8].value = coords[1].ls[2].x;

        form.find('.form-control')[9].value = coords[1].ms[0].x;
        form.find('.form-control')[10].value = coords[1].ms[2].x;

        form.find('.form-control')[11].value = coords[1].s[0].x;

        // Result mf
        form.find('.form-control')[12].value = coords[2].ni[1].x;

        form.find('.form-control')[13].value = coords[2].n[0].x;
        form.find('.form-control')[14].value = coords[2].n[2].x;

        form.find('.form-control')[15].value = coords[2].i[0].x;
        form.find('.form-control')[16].value = coords[2].i[2].x;

        form.find('.form-control')[17].value = coords[2].vi[0].x;
};
setInputs();


var chart1 = new Chartist.Line('#ct-chart-1', {
  series: [
    {
      name: 'series-1',
      data: coords[0].vq,
    },
    {
      name: 'series-2',
      data: coords[0].q,
    },
    {
      name: 'series-3',
      data: coords[0].l,
    },
    {
      name: 'series-4',
      data: coords[0].vl,
    }
  ]
}, {
    lineSmooth: false,
    showPoint: false,
    showArea: true,
    axisX: {
        type: Chartist.FixedScaleAxis,
        divisor: 15,
        low: 0,
        high: 75,
        onlyInteger: true,
    },
    axisY: {
        type: Chartist.FixedScaleAxis,
        divisor: 2,
        low: 0,
        high: 1,
        onlyInteger: true,
    }
});

var chart2 = new Chartist.Line('#ct-chart-2', {
  series: [
    {
      name: 'series-1',
      data: coords[1].ns,
    },
    {
      name: 'series-2',
      data: coords[1].ms,
    },
    {
      name: 'series-3',
      data: coords[1].ls,
    },
    {
      name: 'series-4',
      data: coords[1].s,
    }
  ]
}, {
    fullWidth: true,
    showPoint: false,
    showArea: true,
    lineSmooth: false,
    axisX: {
        type: Chartist.FixedScaleAxis,
        divisor: 25,
        low: 0,
        high: 125,
        onlyInteger: true,
    },
    axisY: {
        type: Chartist.FixedScaleAxis,
        divisor: 2,
        low: 0,
        high: 1,
        onlyInteger: true,
    }
});

var chart3 = new Chartist.Line('#ct-chart-3', {
  series: [
    {
      name: 'series-1',
      data: coords[2].ni,
    },
    {
      name: 'series-2',
      data: coords[2].n,
    },
    {
      name: 'series-3',
      data: coords[2].i,
    },
    {
      name: 'series-4',
      data: coords[2].vi,
    }
  ]
}, {
    fullWidth: true,
    showPoint: false,
    showArea: true,
    lineSmooth: false,
    axisX: {
        type: Chartist.FixedScaleAxis,
        divisor: 25,
        low: 0,
        high: 125,
        onlyInteger: true,
    },
    axisY: {
        type: Chartist.FixedScaleAxis,
        divisor: 2,
        low: 0,
        high: 1,
        onlyInteger: true,
    }
});

$('#mf-form').find('.form-control').change(function() {
        var form = $('#mf-form');
        
        // First mf
        coords[0].vq[1].x = form.find('.form-control')[0].value;

        coords[0].q[0].x = form.find('.form-control')[1].value;
        coords[0].q[2].x = form.find('.form-control')[2].value;
        
        coords[0].l[0].x = form.find('.form-control')[3].value;
        coords[0].l[2].x = form.find('.form-control')[4].value;
        
        coords[0].vl[0].x = form.find('.form-control')[5].value;
        
        // Second mf
        coords[1].ns[1].x = form.find('.form-control')[6].value;

        coords[1].ls[0].x = form.find('.form-control')[7].value;
        coords[1].ls[2].x = form.find('.form-control')[8].value;

        coords[1].ms[0].x = form.find('.form-control')[9].value;
        coords[1].ms[2].x = form.find('.form-control')[10].value;

        coords[1].s[0].x = form.find('.form-control')[11].value;
        
        // Result mf
        coords[2].ni[1].x = form.find('.form-control')[12].value;

        coords[2].n[0].x = form.find('.form-control')[13].value;
        coords[2].n[2].x = form.find('.form-control')[14].value;

        coords[2].i[0].x = form.find('.form-control')[15].value;
        coords[2].i[2].x = form.find('.form-control')[16].value;

        coords[2].vi[0].x = form.find('.form-control')[17].value;
        
        chart1.update();
        chart2.update();
        chart3.update();
});


    $('.save-btn').click(function(e) {
        
        e.preventDefault();
        var form = $('#mf-form');
        
        // First mf
        coords[0].vq[1].x = form.find('.form-control')[0].value;

        coords[0].q[0].x = form.find('.form-control')[1].value;
        coords[0].q[2].x = form.find('.form-control')[2].value;
        
        coords[0].l[0].x = form.find('.form-control')[3].value;
        coords[0].l[2].x = form.find('.form-control')[4].value;
        
        coords[0].vl[0].x = form.find('.form-control')[5].value;
        
        // Second mf
        coords[1].ns[1].x = form.find('.form-control')[6].value;

        coords[1].ls[0].x = form.find('.form-control')[7].value;
        coords[1].ls[2].x = form.find('.form-control')[8].value;

        coords[1].ms[0].x = form.find('.form-control')[9].value;
        coords[1].ms[2].x = form.find('.form-control')[10].value;

        coords[1].s[0].x = form.find('.form-control')[11].value;
        
        // Result mf
        coords[2].ni[1].x = form.find('.form-control')[12].value;

        coords[2].n[0].x = form.find('.form-control')[13].value;
        coords[2].n[2].x = form.find('.form-control')[14].value;

        coords[2].i[0].x = form.find('.form-control')[15].value;
        coords[2].i[2].x = form.find('.form-control')[16].value;

        coords[2].vi[0].x = form.find('.form-control')[17].value;
        
        chart1.update();
        chart2.update();
        chart3.update();
        
        form.append($('<input>', {
                'name': 'MembershipFunctions[coords]',
                'value': JSON.stringify(coords),
                'type': 'hidden'
        })).submit();

        return true;
    });
    
    $('.default-btn').click(function(e) {
        
        e.preventDefault();
        
        coords = defaultCoords;
        setInputs();
        
        chart1.update({series: [
            {
              name: 'series-1',
              data: defaultCoords[0].vq,
            },
            {
              name: 'series-2',
              data: defaultCoords[0].q,
            },
            {
              name: 'series-3',
              data: defaultCoords[0].l,
            },
            {
              name: 'series-4',
              data: defaultCoords[0].vl,
            }
          ]}
        );
        chart2.update({
          series: [
            {
              name: 'series-1',
              data: defaultCoords[1].ns,
            },
            {
              name: 'series-2',
              data: defaultCoords[1].ms,
            },
            {
              name: 'series-3',
              data: defaultCoords[1].ls,
            },
            {
              name: 'series-4',
              data: defaultCoords[1].s,
            }
          ]
        });
        chart3.update({
          series: [
            {
              name: 'series-1',
              data: defaultCoords[2].ni,
            },
            {
              name: 'series-2',
              data: defaultCoords[2].n,
            },
            {
              name: 'series-3',
              data: defaultCoords[2].i,
            },
            {
              name: 'series-4',
              data: defaultCoords[2].vi,
            }
          ]
        });

        return true;
    });



JS
);

?>

    <div class="col-md-10 col-md-push-1">
            <? $form = ActiveForm::begin([
                'layout' => 'inline',
                'id' => 'mf-form',
            ])?>
                <h3><strong style=" background-color:lightgray; border-radius: 5px; padding: 5px">Время</strong></h3>
                <div class="ct-chart ct-perfect-fourth" id="ct-chart-1" style="height:200px; width:600px"></div>
                <span class="term-space" style="color: green"><strong>Очень быстро:</strong>
                    <?= $form->field($mf, 'mf')
                        ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                </span>
                <span class="term-space" style="color:#f05b4f"><strong>Быстро:</strong>
                    <?= $form->field($mf, 'mf')
                        ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                    <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                </span>
                <span class="term-space" style="color:#f4c63d"><strong>Долго:</strong>
                    <?= $form->field($mf, 'mf')
                        ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                    <?= $form->field($mf, 'mf')
                        ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                    </span>
                <span class="term-space" style="color:#d17905;"><strong>Очень долго:</strong>
                    <?= $form->field($mf, 'mf')
                        ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                </span>
                <hr>
            <h3><strong style=" background-color:lightgray; border-radius: 5px; padding: 5px">Область интересов</strong></h3>
            <div class="ct-chart ct-perfect-fourth" id="ct-chart-2" style="height:200px; width:600px;"></div>
            <span class="term-space" style="color: green"><strong>Не подходит:</strong>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                </span>
            <span class="term-space" style="color:#f4c63d "><strong>Меньше подходит:</strong>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                </span>
            <span class="term-space" style="color:#f05b4f"><strong>Больше подходит:</strong>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                    </span>
            <span class="term-space" style="color:#d17905;"><strong>Подходит:</strong>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                </span>
            <br>
            <hr>
<!--        Result MF-->
            <h3><strong style=" background-color:lightgray; border-radius: 5px; padding: 5px">Значимость новости</strong></h3>
            <div class="ct-chart ct-perfect-fourth" id="ct-chart-3" style="height:200px; width:600px;"></div>
            <span class="term-space" style="color: green"><strong>Не интересна:</strong>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                    </span>
            <span class="term-space" style="color:#f4c63d"><strong>Близка:</strong>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                    </span>
            <span class="term-space" style="color:#f05b4f"><strong>Важна:</strong>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                        </span>
            <span class="term-space" style="color:#d17905;"><strong>Очень важна:</strong>
                <?= $form->field($mf, 'mf')
                    ->textInput(['style' => ['width' => '60px'], 'autocomplete' => 'off'])->label(false) ?>
                    </span>
            <br>
            <hr>
            <?=Html::button('Сохранить', ['class' => 'btn btn-primary save-btn'])?>
            <?=Html::button('По умолчанию', ['class' => 'btn btn-default default-btn'])?>
        <? ActiveForm::end()?>
    </div>