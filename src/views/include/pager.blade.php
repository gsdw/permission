<div class="row">
    <div class="col-sm-4">
        <div class="dataTables_info" role="status" aria-live="polite">
            Showing {{ $model->count() }} of {{ $model->total() }} entries / 
            {{ ceil($model->total() / $model->perpage()) }} pages
        </div>
    </div>

    <div class="col-sm-2">
        <div class="dataTables_length">
            <label>Show
                <select name="limit" class="form-control input-sm" onchange="window.location.href = this.value;">
                    @foreach(\Gsdw\Base\Helpers\Options::limit() as $option)
                        <option value="{{ \Gsdw\Base\Helpers\General::getUrlReplaceParams(['limit' => $option['value']]) }}"
                                @if ($option['value'] == $model->perPage())
                                    selected
                                @endif
                        >{{ $option['label'] }}</option>
                    @endforeach
                </select>
            </label>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="dataTables_paginate paging_simple_numbers">
            <ul class="pagination">
                <li class="paginate_button first-page
                    @if($model->currentPage() == 1)
                        disabled
                    @endif
                ">
                    <a href="
                        @if($model->currentPage() != 1)
                            {{ \Gsdw\Base\Helpers\General::getUrlReplaceParams(['page' => 1]) }}
                        @else
                            #
                        @endif
                    ">
                        <i class="fa fa-angle-double-left"></i>
                    </a>
                </li>
                <li class="paginate_button previous
                    @if($model->currentPage() == 1)
                        disabled
                    @endif
                ">
                    <a href="
                       @if($model->currentPage() != 1)
                            {{ \Gsdw\Base\Helpers\General::getUrlReplaceParams(['page' => $model->currentPage()-1]) }}
                        @else
                            #
                        @endif
                    ">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                </li>
                <li class="paginate_button">
                    <form action="{{ \Gsdw\Base\Helpers\General::getUrlReplaceParams(['page' => null]) }}" method="get" class="form-pager">
                        <input class="input-text form-control" name="page" value="{{ $model->currentPage() }}" />
                    </form>
                </li>
                <li class="paginate_button next
                    @if(!$model->hasMorePages())
                        disabled
                    @endif
                ">
                    <a href="
                       @if($model->hasMorePages())
                            {{ \Gsdw\Base\Helpers\General::getUrlReplaceParams(['page' => $model->currentPage()+1]) }}
                        @else
                            #
                        @endif
                    ">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </li>
                <li class="paginate_button lastpage-page
                    @if($model->lastPage() == $model->currentPage())
                        disabled
                    @endif
                ">
                    <a href="
                       @if($model->lastPage() != $model->currentPage())
                            {{ \Gsdw\Base\Helpers\General::getUrlReplaceParams(['page' => $model->lastPage()]) }}
                        @else
                            #
                        @endif
                    ">
                        <i class="fa fa-angle-double-right"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
