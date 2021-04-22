<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            
        <div class="row">
          <div class="col-md-3">
            <!-- Widget: user widget style 2 -->
            <div class="card card-widget card-primary widget-user-2">
                <div class="card-header">
                <h3 class="card-title">Reports</h3>
              </div>
              <div class="card-footer p-0">
                <ul class="nav flex-column">
                  <li class="nav-item nav-tabs">
                    <a href="#plantilla" class="nav-link active nav-tabs" data-toggle="tab">
                      Plantilla <span class="float-right"><i class="fas fa-leaf"></i></span>
                    </a>
                  </li>
                  <li class="nav-item nav-tabs">
                    <a href="#nosa" class="nav-link nav-tabs" data-toggle="tab">
                      NOSA (Notice of Salary Adjustment) <span class="float-right"><i class="fas fa-hand-holding-usd"></i></span>
                    </a>
                  </li>
                  <li class="nav-item nav-tabs">
                    <a href="#nosi" class="nav-link nav-tabs" data-toggle="tab">
                      NOSI (Notice of Step Increment) <span class="float-right"><i class="fas fa-chart-line"></i></span>
                    </a>
                  </li>
                  <li class="nav-item nav-tabs">
                    <a href="#service" class="nav-link nav-tabs" data-toggle="tab">
                      Service Record <span class="float-right"><i class="fas fa-book"></i></span>
                    </a>
                  </li>
                  <li class="nav-item nav-tabs">
                    <a href="#salary" class="nav-link nav-tabs" data-toggle="tab">
                      Salary Schedule <span class="float-right"><i class="fas fa-file-invoice-dollar"></i></span>
                    </a>
                  </li>
                  <li class="nav-item nav-tabs">
                    <a href="#roster" class="nav-link nav-tabs" data-toggle="tab">
                      Personnel Roster <span class="float-right"><i class="fas fa-people-arrows"></i></span>
                    </a>
                  </li>
                  <li class="nav-item nav-tabs">
                    <a href="#alloc" class="nav-link nav-tabs" data-toggle="tab">
                      Allocation List <span class="float-right"><i class="fas fa-hands-helping"></i></span>
                    </a>
                  </li>
                  <li class="nav-item nav-tabs">
                    <a href="#loyalty" class="nav-link nav-tabs" data-toggle="tab">
                      Loyalty Benefits Schedule <span class="float-right"><i class="fas fa-hand-holding-heart"></i></span>
                    </a>
                  </li>
                  <li class="nav-item nav-tabs">
                    <a href="#job" class="nav-link nav-tabs" data-toggle="tab">
                      Job Description <span class="float-right"><i class="fas fa-briefcase"></i></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /.widget-user -->
          </div>
          <div class="col-md-9">

            <!-- Plantilla Tab -->
           <div class="tab-content">
            <div class="tab-pane active" id="plantilla">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Plantilla <i class="fas fa-leaf"></i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <label class="text-muted" style="font-weight: 400; line-height: 10px;">Department</label>
                </div>
                <div class="form-group" style="display: flex;">
                    
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0" style="margin-right: 15px; width: 69%;">
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  
                 
                  <a class="btn bg-info" style="margin-right: 5px;">
                  Plantilla
                    <i class="fas fa-print"></i>
                  </a>
                  <a class="btn bg-success">
                  Summary
                    <i class="fas fa-print"></i>
                  </a>
               
                </div>
                
                </div>
              </div>
            </div>

            <!-- End Plantilla Tab -->

            <!-- NOSA -->
            <div class="tab-pane" id="nosa">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">NOSA (Notice of Salary Adjustment) <i class="fas fa-hand-holding-usd"></i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" style="display: flex;">
                  <div class="col-md-6" >
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Department</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  </div>
                  <div class="col-md-6">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Employee</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>All Employees</option>
                    <option>Gene Rellanos</option>
                    <option>Zak Ongkas</option>
                  </select>
                  </div>
                </div>
                <div class="form-group" style="display: flex;">
                  <div class="col-md-4">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Print Date</label>
                    </div>
                    <input id="date_approved" type="text" name="date_approved" placeholder="yyyy-mm-dd" onkeypress="return event.charCode > 47 &amp;&amp; event.charCode < 58;" onkeydown="var date = this.value;
                                            if (window.event.keyCode == 8) {
                                                this.value = date;
                                            } else if (date.match(/^\d{4}$/) !== null) {
                                                this.value = date + '-';
                                            } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                this.value = date + '-';
                                            }
                                        " maxlength="10" required="required" class="form-control rounded-0 form-control-border border-width-2">

                  </div>
                  <div class="col-md-4">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Salary Adjusted Effectivity</label>
                    </div>
                    <input id="date_approved" type="text" name="date_approved" placeholder="yyyy-mm-dd" onkeypress="return event.charCode > 47 &amp;&amp; event.charCode < 58;" onkeydown="var date = this.value;
                                            if (window.event.keyCode == 8) {
                                                this.value = date;
                                            } else if (date.match(/^\d{4}$/) !== null) {
                                                this.value = date + '-';
                                            } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                this.value = date + '-';
                                            }
                                        " maxlength="10" required="required" class="form-control rounded-0 form-control-border border-width-2">

                  </div>
                  <div class="col-md-4">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Monthly Basic Salary as of</label>
                    </div>
                    <input id="date_approved" type="text" name="date_approved" placeholder="yyyy-mm-dd" onkeypress="return event.charCode > 47 &amp;&amp; event.charCode < 58;" onkeydown="var date = this.value;
                                            if (window.event.keyCode == 8) {
                                                this.value = date;
                                            } else if (date.match(/^\d{4}$/) !== null) {
                                                this.value = date + '-';
                                            } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                this.value = date + '-';
                                            }
                                        " maxlength="10" required="required" class="form-control rounded-0 form-control-border border-width-2">

                  </div>
                
                </div>
                <div class="form-group" style="display: flex;">
                  <div class="col-md-6">
                  <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Local Budget Circular No.</label>
                    </div>
                  <input type="text" class="form-control rounded-0 form-control-border border-width-2" id="exampleInputRounded0">
                  
                </div>
                <div class="col-md-6">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Dated</label>
                    </div>
                    <input id="date_approved" type="text" name="date_approved" placeholder="yyyy-mm-dd" onkeypress="return event.charCode > 47 &amp;&amp; event.charCode < 58;" onkeydown="var date = this.value;
                                            if (window.event.keyCode == 8) {
                                                this.value = date;
                                            } else if (date.match(/^\d{4}$/) !== null) {
                                                this.value = date + '-';
                                            } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                this.value = date + '-';
                                            }
                                        " maxlength="10" required="required" class="form-control rounded-0 form-control-border border-width-2">

                  </div>
                  
                  </div>
                  <div class="col-md-12" style=" margin-top: 23px;">
                    <a class="btn bg-primary float-right">
                        Print
                    <i class="fas fa-print"></i>
                  </a>
                </div>
              </div>
            </div>
            </div>
            <!-- End NOSA -->


          <!-- NOSI -->


           <div class="tab-pane" id="nosi">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">NOSI (Notice of Step Increment) <i class="fas fa-chart-line"></i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" style="display: flex;">
                  <div class="col-md-6" >
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Department</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  </div>
                  <div class="col-md-6">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Employee</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>All Employees</option>
                    <option>Gene Rellanos</option>
                    <option>Zak Ongkas</option>
                  </select>
                  </div>
                </div>
                <div class="form-group" style="display: flex;">
                  <div class="col-md-8">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Print Date</label>
                    </div>
                    <input id="date_approved" type="text" name="date_approved" placeholder="yyyy-mm-dd" onkeypress="return event.charCode > 47 &amp;&amp; event.charCode < 58;" onkeydown="var date = this.value;
                                            if (window.event.keyCode == 8) {
                                                this.value = date;
                                            } else if (date.match(/^\d{4}$/) !== null) {
                                                this.value = date + '-';
                                            } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                this.value = date + '-';
                                            }
                                        " maxlength="10" required="required" class="form-control rounded-0 form-control-border border-width-2">

                  </div>
                  <div class="col-md-4" style=" margin-top: 23px;">
                    <a class="btn bg-primary float-right">
                        Print
                    <i class="fas fa-print"></i>
                  </a>
                </div>
                </div>
              </div>
            </div>
            </div>


          <!-- END NOSI -->


          <!-- Service Record -->

              <div class="tab-pane" id="service">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Service Record <i class="fas fa-book"></i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" style="display: flex;">
                  <div class="col-md-6" >
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Department</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  </div>
                  <div class="col-md-6">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Employee</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>All Employees</option>
                    <option>Gene Rellanos</option>
                    <option>Zak Ongkas</option>
                  </select>
                  </div>
                </div>
                <div class="form-group" style="display: flex;">
                  <div class="col-md-4">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Date Issued</label>
                    </div>
                    <input id="date_approved" type="text" name="date_approved" placeholder="yyyy-mm-dd" onkeypress="return event.charCode > 47 &amp;&amp; event.charCode < 58;" onkeydown="var date = this.value;
                                            if (window.event.keyCode == 8) {
                                                this.value = date;
                                            } else if (date.match(/^\d{4}$/) !== null) {
                                                this.value = date + '-';
                                            } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                this.value = date + '-';
                                            }
                                        " maxlength="10" required="required" class="form-control rounded-0 form-control-border border-width-2">

                  </div>
                  <div class="col-md-4">
                <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Amount</label>
                    </div>
                  <input type="number" class="form-control rounded-0 form-control-border border-width-2" id="exampleInputRounded0">
                  
                </div>
                <div class="col-md-4">
                  <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Certified Correct</label>
                    </div>
                  <input type="text" class="form-control rounded-0 form-control-border border-width-2" id="exampleInputRounded0">
                  
                </div>
                </div>
                <div class="col-md-12" style=" margin-top: 23px;">
                    <a class="btn bg-primary float-right">
                        Print
                    <i class="fas fa-print"></i>
                  </a>
                </div>
              </div>
            </div>
            </div>

          <!-- End Service Record -->

          <!-- Salary Schedule -->

          <div class="tab-pane" id="salary">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Salary Schedule <i class="fas fa-file-invoice-dollar"></i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" style="display: flex;">
                  <div class="col-md-12" >
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Salary Schedule</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  </div>
                  
                </div>
                
                <div class="col-md-12" style=" margin-top: 23px;">
                    <a class="btn bg-primary float-right">
                        Print
                    <i class="fas fa-print"></i>
                  </a>
                </div>
              </div>
            </div>
            </div>

          <!-- End Salary Schedule -->


          <!-- Personnel Schedule -->


         <div class="tab-pane" id="roster">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Personnel Roster <i class="fas fa-people-arrows"></i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" style="display: flex;">
                  <div class="col-md-8" >
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Department</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  </div>
                  <div class="col-md-4">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Print Date</label>
                    </div>
                    <input id="date_approved" type="text" name="date_approved" placeholder="yyyy-mm-dd" onkeypress="return event.charCode > 47 &amp;&amp; event.charCode < 58;" onkeydown="var date = this.value;
                                            if (window.event.keyCode == 8) {
                                                this.value = date;
                                            } else if (date.match(/^\d{4}$/) !== null) {
                                                this.value = date + '-';
                                            } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                this.value = date + '-';
                                            }
                                        " maxlength="10" required="required" class="form-control rounded-0 form-control-border border-width-2">

                  </div>
                </div>
                
                <div class="col-md-12" style=" margin-top: 23px;">
                    <a class="btn bg-primary float-right">
                        Print
                    <i class="fas fa-print"></i>
                  </a>
                </div>
              </div>
            </div>
            </div>

          <!-- End Personnel Schedule -->


          <!-- Allocation List -->

                <div class="tab-pane" id="alloc">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Allocation List <i class="fas fa-hands-helping"></i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" style="display: flex;">
                  <div class="col-md-8" >
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Department</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  </div>
                  <div class="col-md-4">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Print Date</label>
                    </div>
                    <input id="date_approved" type="text" name="date_approved" placeholder="yyyy-mm-dd" onkeypress="return event.charCode > 47 &amp;&amp; event.charCode < 58;" onkeydown="var date = this.value;
                                            if (window.event.keyCode == 8) {
                                                this.value = date;
                                            } else if (date.match(/^\d{4}$/) !== null) {
                                                this.value = date + '-';
                                            } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                this.value = date + '-';
                                            }
                                        " maxlength="10" required="required" class="form-control rounded-0 form-control-border border-width-2">

                  </div>
                </div>
                
                <div class="col-md-12" style=" margin-top: 23px;">
                    <a class="btn bg-primary float-right">
                        Print
                    <i class="fas fa-print"></i>
                  </a>
                </div>
              </div>
            </div>
            </div>

          <!-- End Allocation list -->

          <!-- Loyalty Benefits Schedule -->

              <div class="tab-pane " id="loyalty">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Loyalty Benefits Schedule <i class="fas fa-hand-holding-heart"></i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" style="display: flex;">
                  <div class="col-md-8" >
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Department</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  </div>
                  <div class="col-md-4">
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Date Issued</label>
                    </div>
                    <input id="date_approved" type="text" name="date_approved" placeholder="yyyy-mm-dd" onkeypress="return event.charCode > 47 &amp;&amp; event.charCode < 58;" onkeydown="var date = this.value;
                                            if (window.event.keyCode == 8) {
                                                this.value = date;
                                            } else if (date.match(/^\d{4}$/) !== null) {
                                                this.value = date + '-';
                                            } else if (date.match(/^\d{4}\-\d{2}$/) !== null) {
                                                this.value = date + '-';
                                            }
                                        " maxlength="10" required="required" class="form-control rounded-0 form-control-border border-width-2">

                  </div>
                </div>
                
                <div class="col-md-12" style=" margin-top: 23px;">
                    <a class="btn bg-primary float-right">
                        Print
                    <i class="fas fa-print"></i>
                  </a>
                </div>
              </div>
            </div>
            </div>

          <!-- End Loyalty Benefits Schedule -->
          

          <!-- Job Description -->

            <div class="tab-pane " id="job">
              <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Job Description <i class="fas fa-briefcase"></i></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="form-group" style="display: flex;">
                  <div class="col-md-6" >
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Department</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  </div>

                  <div class="col-md-6" >
                    <div>
                      <label class="text-muted" style="font-weight: 400; line-height: 10px;">Position</label>
                    </div>
                  <select class="custom-select rounded-0 form-control-border border-width-2" id="exampleSelectRounded0">
                    <option>Imbalmer</option>
                    <option>Office of the Provincial Engineer</option>
                    <option>Office of the Provincial Engineer</option>
                  </select>
                  </div>
                  
                </div>
                
                <div class="col-md-12" style=" margin-top: 23px;">
                    <a class="btn bg-primary float-right">
                        Print
                    <i class="fas fa-print"></i>
                  </a>
                </div>
              </div>
            </div>
            </div>

          <!-- End Job Description -->
           </div>
          </div>
          </div>
         </div>
        </div>
        
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
