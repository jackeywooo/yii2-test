<?php
/**
 * Created by PhpStorm.
 * User: 95
 * Date: 2019/1/19
 * Time: 19:12
 */

namespace app\commands;
use yii\console\Controller;
/**
 * 排序算法测试
 * Class AlgorithmSortController
 * @package app\commands
 */
class AlgorithmSortController extends Controller
{

    public $testArray = [7,2,1,5,3,9,0,11,4,81];

    public function swap(&$a, &$b) {
        $temp = $a;
        $a = $b;
        $b = $temp;
    }

    public function output(array $sorted) {
        echo "排序前: ";
        print_r($this->testArray);
        echo "排序后: ";
        print_r($sorted);
    }

    /**
     * 冒泡排序
     */
    public function actionBubble() {
        $count = count($this->testArray);
        $array = $this->testArray;

        for($i=0; $i<$count-1; $i++) {
            $flag = false;

            for($j=1;$j<$count-$i; $j++) {
                if($array[$j-1] > $array[$j]) {
                    $this->swap($array[$j-1],$array[$j]);
                    $flag = true;
                }
            }
            if($flag === false) break;

        }
        $this->output($array);
    }

    /**
     * 选择排序
     */
    public function actionSelect()
    {
        $count = count($this->testArray);
        $array = $this->testArray;

        for($i=0; $i< $count - 1; $i++) {
            $min = $i;
            for($j=$count-1; $j>$i; $j--) {
                if($array[$j] < $array[$min]) {
                    $min = $j;
                }
            }
            $this->swap($array[$i], $array[$min]);
        }
        $this->output($array);
    }

    /**
     * 插入排序
     * 核心思想：假设左边的子数组[0,i]已经有序，每次将子数组[0,i]与第i+1个元素比较大小，若发现有大于i+1的元素直接交换位置
     */

    public function actionInsert()
    {
        $count = count($this->testArray);
        $array = $this->testArray;

        for($i=1; $i<$count-1; $i++) {
            for($j=0; $j<$i; $j++) {
                if($array[$j] > $array[$i]) {
                    $this->swap($array[$j] , $array[$i]);
                }
            }
        }

        $this->output($array);
    }


    /**
     * 希尔排序(又名叫缩小增量排序)
     */
    public function actionShell()
    {
        $count = count($this->testArray);
        $array = $this->testArray;

        $dis = $count / 2;  //缩进量
        for($i=$dis; $i>0; $i--) {
            for($j=0; $j<$i; $j++) {
                for($k=$j;$k+$i < $count-1;$k=$k+$i) {
                    if($array[$k] > $array[$k+$i]) {
                        $this->swap($array[$k],$array[$k+$i]);
                    }
                }
            }
        }
        $this->output($array);
    }

    /**
     * 快速排序
     * 基本思想（左右两边两两交换小于flag的和大于flag的，直到start和end重合位置，然后交换flag与重合的位置)
     * 需要递归
     * 注意！ 在key选取最左边元素时，必须从右边开始！
     */
    public function Quick($array)
    {
        //判断是否是一个数组
        if(!is_array($array)) return false;
        $length = count($array);
        if($length<=1) return $array;

        $left = [];
        $right = [];

        for($i=1;$i<$length;$i++) {
            echo $i;
            if($array[$i] < $array[0]) {
                $left[] = $array[$i];
            } else {
                $right[] = $array[$i];
            }
        }
        $right = $this->Quick($right);
        $left = $this->Quick($left);


        return array_merge($left,[$array[0]],$right);
    }

    public function actionQuick() {
        $result = $this->Quick($this->testArray);

        $this->output($result);
    }

    /**
     * 归并排序(将数组分割成2,4,8..个元素的子数组各自排序)
     */
    public function Merge($array, $start, $end, $tempArray) {
        if($start >= $end) return;

        $mid = ($start + $end) / 2;
        $this->Merge($array, $start, $mid, $tempArray);
        $this->Merge($array, $mid+1, $end, $tempArray);

        

    }

    public function actionMerge() {
        $result = $this->Merge($this->testArray,[]);

        $this->output($result);
    }

}

