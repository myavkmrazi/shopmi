<div class="row">
    <div class="col-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Управление категориями</h6>
                <a href="{{ route('admin.categories.create') }}" wire:navigate class="btn btn-primary">
                    <i class="fas fa-plus mr-1"></i> Добавить категорию
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead class="bg-light">
                            <tr>
                                <th width="70" class="text-center">ID</th>
                                <th>Название категории</th>
                                <th width="220" class="text-center">Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            {!! \App\Helpers\Category\Category::getMenu('incs.menu-table-tpl') !!}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
