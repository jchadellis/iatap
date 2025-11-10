<style>
.selected{
    background: #e1c7ffff; 
    border-color: #af96ccff !important; 
}

* {
  box-sizing: border-box;
}

.rc-cell {
  height: 30px;
  flex-shrink: 0;
  position: relative;
  background-color: #fff;
}

.grid-layer {
  display: flex;
  flex-direction: column;
}

.events-layer {
  pointer-events: none; /* events are rendered above cells */
}

.resource-column {
  position: relative;
}

.event {
    position: absolute;
    top: 2px;
    left: 2px;
    right: 2px;
    height: calc(100% - 4px);
    font-size: 0.75rem;
}

.has-event{
  pointer-event:none; 
}


</style>


<div id="calendar">

</div>

