<template>
    <div class="row">
        <div class="col-sm-12">
            <h2>Note Taking App</h2>
        </div>
        <div class="col-sm-12">
            <div class="notes-menu">

                <div class="pull-right" style="width:40%;">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Search">
                </div>

                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                    <div class="btn-group mr-2" role="group" aria-label="First group">
                        <button type="button" class="btn btn-secondary"><i class="fa fa-folder"></i></button>
                    </div>
                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                        <button type="button" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                    </div>
                    <div class="btn-group" role="group" aria-label="Third group">
                        <button type="button" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </div>
                </div>


            </div>
            <div class="notes-main-container">
                <div class="d-flex bg-light" style="height:500px">
                    <div id="folders-menu" class="p-3 border">
                        <ul class="nav flex-column navbar-dark bg-dark">
                          <li class="nav-item">
                            <a class="nav-link active" href="#">Active</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link disabled" href="#">Disabled</a>
                          </li>
                        </ul>
                    </div>
                    <div id="notes-list" class="p-0 border" style="overflow-y:scroll;">
                        <div class="d-flex flex-column">
                            <div class="p-2 note-preview">
                                <h4>Title 1</h4>
                                <span>Content</span>
                            </div>
                            <div class="p-2 bg-light note-preview">
                                <h4>Title 2</h4>
                                <span>Content</span>
                            </div>
                            <div class="p-2 bg-light note-preview">
                                <h4>Title 3</h4>
                                <span>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore
                                    magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                    Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                                    Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span>
                            </div>
                        </div>
                    </div>
                    <div id="current-note" class="p-3 border">
                        <div contenteditable="true">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    name: "",
    data: () => ({

    })
}
</script>
<style lang="scss" scoped>
.notes-menu{
    width: 100%;
    background: #dddddd;
    padding: 10px;
    border: 1px solid #e2e6e9;
}

.notes-main-container{
    width: 100%;
    background: #ffffff;
    border: 1px solid #e2e6e9;
}

#folders-menu{
    width: 25%;
}

#notes-list{
    width: 25%;
}

#current-note{
    width: 75%;
}

.note-preview{
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    border-bottom: 1px solid #e2e6e9;
}
</style>
