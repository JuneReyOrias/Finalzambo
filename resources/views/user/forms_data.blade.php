@extends('user.user_dashboard')
@section('user') 


<div class="page-content">

    <nav class="page-breadcrumb">
  
    </nav>
   
    <div class="row">
      <div class="col-md-12 grid-margin">
        <div class="card">
          <div class="card-body">

            @if (session('message'))
            <div class="alert alert-success" role="alert">
              {{ session('message')}}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
               
            @endif
            <h6 class="card-title">Farmers Rice Productions</h6>
            <p class="text-success">This page provides a clear overview of the personal data we have collected about you, including categories of information, purposes of collection, data usage, sharing practices, security measures, and options for data access and control. We are committed to transparency and safeguarding your privacy rights.</p><br>
         
           <div class="table-responsive tab ">
            <table class="table table table-info">
                <thead class="thead-light">
                    <tr >
                  
                        <th>Farmer No.</th>
                        <th>Last Name</th>
                        <th>Firt Name</th>
                        <th>Middle Name</th>
                        <th>tenurial status</th>
                        <th>total Fixed cost</th>
                        <th>total cost for_machineries</th>
                        <th>total seed cost</th>
                        <th>total cost fertilizers</th>
                        <th>total labor cost</th>
                        <th>total cost pesticides</th>
                        <th>total transport per_deliverycost</th>
                        <th>total machinery fuel_cost</th>
                        <th>gross income palay</th>
                        <th>gross income rice</th>
                       

                      
                    </tr>
                </thead>
                <tbody>
                  @if( $allfarmers->count() > 0)
                @foreach( $allfarmers->sortByDesc('id') as  $allfarmer)
                    <tr class="table-light">
                         <td>{{ $loop->iteration }}</td>
                         
                         <td>{{ $allfarmer->last_name }}</td>
                         <td>{{ $allfarmer->first_name }}</td>
                         <td>{{ $allfarmer->middle_name }}</td>
                         <td>{{ $allfarmer->tenurial_status }}</td>
                           <td>{{ $allfarmer->total_amount}}</td>
                           <td>{{ $allfarmer->total_cost_for_machineries }}</td>
                           <td>{{ $allfarmer->total_seed_cost }}</td>
                           <td>{{ $allfarmer->total_cost_fertilizers }}</td>
                           <td>{{ $allfarmer->total_labor_cost}}</td>
                           <td>{{ $allfarmer->total_cost_pesticides }}</td>
                           <td>{{ $allfarmer->total_transport_per_deliverycost }}</td>
                           <td>{{ $allfarmer->total_machinery_fuel_cost}}</td>
                           <td>{{ $allfarmer->gross_income_palay}}</td>
                           <td>{{ $allfarmer->gross_income_rice }}</td>
                          
                        <td>
                           
                             {{-- <a href="{{route('agent.farmprofile.farm_update',  $allfarmer->id)}}" title="Edit Student"><button class="btn btn-primary btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button></a> 
                
                             <form  action="{{ route('agent.farmprofile.delete',  $allfarmer->id) }}"method="post" accept-charset="UTF-8" style="display:inline">
                              @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Student" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                            </form>
                             --}}
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="5">Personal Informations not found</td>
                </tr>
            @endif
                </tbody>
            </table>
        </div>
  
   
          </div>
                        <!-- Pagination links -->
            <div class="row"style="align-content: center;display: flex;
            align-items: center; align-self: center">
                <div class="col-md-7" style="align-content: center;display: flex;
                align-items: center;">
                    {{ $allfarmers->links() }}
                </div>
            </div>
        </div>
      </div>
    </div>
</div>
</div>
</div>

</div>

</div>@endsection