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

    public function QuickBetter(&$array, $start , $end) {
        print_r($array);
        $i = $start;
        $j = $end;
        if($start > $end) return;
        $flag = $array[$start];

        while($i < $j) {
            while($array[$j] >= $flag && $i < $j)
                $j--;
            while($array[$i] <= $flag && $i < $j)
                $i++;
            $this->swap($array[$i], $array[$j]);

        }

            $this->swap($array[$start],$array[$i]);
//print_r($array);

        $left = $i-1;
        $right = $i+1;
        echo $start . " " . $left . " " . $right . " " . $end;
        sleep(3);
        $this->QuickBetter($array, $start, $left);
        $this->QuickBetter($array, $right, $end);
    }

    public function actionQuick() {
        //$result = $this->Quick($this->testArray);
        $array = $this->testArray;
        $this->QuickBetter($array, 0 ,count($array)-1);
        $this->output($array);
    }

    /**
     * 归并排序(将数组分割成2,4,8..个元素的子数组各自排序)
     */
    private function merge_sort(&$arr){
        $len=count($arr);
        if($len==1)
            return $arr;
        $middle=intval($len/2);
        $left=array_slice($arr,0,$middle);
        $right=array_slice($arr,$middle);
        $this->merge_sort($left);
        $this->merge_sort($right);
        $arr=$this->merge($left,$right);

        return $arr;
    }

    private function merge($leftarr,$rightarr){
        $arrmerge=array();

        $i = $j = 0;
        $index = 0;
        while($i < count($leftarr) && $j < count($rightarr)) {
            if($leftarr[$i] < $rightarr[$j]) {
                $arrmerge[$index++] = $leftarr[$i++];
            } else {
                $arrmerge[$index++] = $rightarr[$j++];
            }
        }
        while($i < count($leftarr)) {
            $arrmerge[$index++] = $leftarr[$i++];
        }

        while($j < count($rightarr)) {
            $arrmerge[$index++] = $rightarr[$j++];
        }
        return $arrmerge;

    }

    public function actionMerge() {

        $result = $this->merge_sort($this->testArray);
        $this->output($result);
    }

    /**
     * 堆排序
     * @param $array
     * @param $parent
     * @param $length
     */
    public function HeapAdjust(&$array , $parent, $length) {
        $temp = $array[$parent]; //保存父节点
        $child = intval($parent / 2) + 1; //左子节点的index

        while($child < $length) {
            if($child+1 < $length && $array[$child] < $array[$child+1]) {
                $child++;
            }
            if($temp >= $array[$child]) {
                break;
            }
            $array[$parent] = $array[$child];
            $parent = $child;                   //将父节点的index设为子节点
            $child = intval($child / 2) + 1;    //再次选取左子节点
        }

        $array[$parent] = $temp;

    }


    public function HeapSort(&$array) {
        for($i=intval(count($array) / 2); $i>=0; $i-- ) {
            $this->HeapAdjust($array,0,count($array));
        }

        //进行n-1次循环，完成排序
        for($i=count($array)-1;$i>0;$i--) {
            $this->swap($array[$i],$array[0]);
            $this->HeapAdjust($array,0,$i);
        }
    }

    public function actionHeap() {
        $array = $this->testArray;
        $this->HeapSort($array);

        $this->output($array);
    }


/**********************************查找算法***************************************/
    private function binarySearch($array, $i) {
        $start = 0;
        $end = count($array)-1;

        while($start <= $end) {
            $mid  = $start + intval(($end - $start) /2);
            if($array[$mid] == $i){ return $mid;}
            elseif($array[$mid] < $i) {$start = $mid+1;}
            else {$end = $mid -1;}
        }
        return -1;
    }

    public function actionSearch() {
        echo $this->binarySearch([1,2,5,7,9,10], 10);

    }

    /**
     * 用户喜好问题(关键字：为了不断优化推荐效果，今日头条每天要存储和处理海量数据...)
     */
    public function actionUserFavor() {
        $i = 5;
        $favorList = [1,2,3,3,5];
        $m = 3;

        $veiryMap = [
            [1,2,1],
            [2,4,5],
            [3,5,3],
        ];

        //穷举所有被喜好的k作为子数组索引，每个字数组下面存放存在k的FavorList下标
        $map = [];
        foreach($favorList as $location => $favor) {
            $map[$favor][] = $location+1;
        }
        //print_r($map);exit;
        foreach($veiryMap as $key => $array) {
            $k = $array[2];
            $count = 0;
            for($i=0;$i<count($map[$k]);$i++) {

                if($map[$k][$i] >= $array[0] && $map[$k][$i] <= $array[1]) {
                    $count++;
                }
            }
            echo $count . "\n";
        }
    }

}

