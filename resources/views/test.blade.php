@extends('layouts.master')

<div id="stock-div"></div>

<div id="chart"></div>


@linechart('MyStocks', 'stock-div');
@gaugechart('Temps', 'chart')