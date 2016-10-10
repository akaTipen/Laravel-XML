<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\File;

use App\Data;

class DataController extends Controller
{
	public function load()
	{
		$dom = new \DOMDocument();
		$dom->load('data.xml');

		//init
		$array = array();
		//get all form tags
		$rows = $dom->getElementsByTagName('row');
		foreach($rows as $row){
			//get all field-tags from this form
			$fields = $row->getElementsByTagName('field');
			//create an empty element
			$element = array();
			//walk through the input elements of the current form element
			foreach($fields as $field){
				$name = $field->getAttribute('name');
				$value = $field->nodeValue;
				//add the data to element array
				$element[$name] = $value;
			}
			//add the element to your array
			$array[] = $element;
		}
		//print it
		$datas = $array;
    	// var_dump($datas);die;

    	return $datas;
	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$datas = $this->load();
    	return view('data')->with('datas', $datas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add');
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$dom = new \DomDocument('1.0');
    	$dom->load('data.xml');

    	$datas = $this->load();

        $lastArray = end($datas);
        $lastId = $lastArray['id'];

        if(input::hasFile('avatar')) {
	   		$file = Input::file('avatar');
	   		$destinationPath = public_path().'/img';
	    	$filename = $file->getClientOriginalname();
	    	$fileXML = 'img/'.$filename;

	    	$file->move($destinationPath, $filename);	
    	} else {
    		$fileXML = null;
    	}

        $data = $dom->getElementsByTagName('data')->item(0);
        $row = $dom->createElement('row');
        
        $id = $dom->createElement('field', $lastId+1);
        $idAttribute = $dom->createAttribute('name');
        $idAttribute->value = 'id';
        $id->appendChild($idAttribute);

        $name = $dom->createElement('field', $request['name']);
        $nameAttribute = $dom->createAttribute('name');
        $nameAttribute->value = 'name';
        $name->appendChild($nameAttribute);

        $position = $dom->createElement('field', $request['position']);
        $positionAttribute = $dom->createAttribute('name');
        $positionAttribute->value = 'position';
        $position->appendChild($positionAttribute);

        $city = $dom->createElement('field', $request['city']);
        $cityAttribute = $dom->createAttribute('name');
        $cityAttribute->value = 'city';
        $city->appendChild($cityAttribute);

        $email = $dom->createElement('field', $request['email']);
        $emailAttribute = $dom->createAttribute('name');
        $emailAttribute->value = 'email';
        $email->appendChild($emailAttribute);

        $department = $dom->createElement('field', $request['department']);
        $departmentAttribute = $dom->createAttribute('name');
        $departmentAttribute->value = 'department';
        $department->appendChild($departmentAttribute);

        $avatar = $dom->createElement('field', $fileXML);
        $avatarAttribute = $dom->createAttribute('name');
        $avatarAttribute->value = 'avatar';
        $avatar->appendChild($avatarAttribute);

        $status = $dom->createElement('field', $request['status']);
        $statusAttribute = $dom->createAttribute('name');
        $statusAttribute->value = 'status';
        $status->appendChild($statusAttribute);

       	$data->appendChild($row);
       	$row->appendChild($id);
       	$row->appendChild($name);
       	$row->appendChild($position);
       	$row->appendChild($city);
       	$row->appendChild($email);
       	$row->appendChild($department);
       	$row->appendChild($avatar);
       	$row->appendChild($status);

 		$dom->save('data.xml');	    	
         
         return redirect()->to('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        // $post = Post::findOrFail($id);

        /**
	    *
		* Using DomXML
		*
		*/
  		$document = new \DomDocument('1.0');
		$document->load('data.xml');

		$xpath = new \DOMXpath($document);

		$name = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="name"]');
		$position = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="position"]');
		$city = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="city"]');
		$email = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="email"]');
		$department = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="department"]');
		$avatar = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="avatar"]');
		$status = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="status"]');

		$row = array('id'=>$id, 'name'=>$name['domnodelist']->textContent, 'position'=>$position['domnodelist']->textContent, 'city'=>$city['domnodelist']->textContent,
			'email'=>$email['domnodelist']->textContent, 'department'=>$department['domnodelist']->textContent, 'avatar'=>$avatar['domnodelist']->textContent, 'status'=>$status['domnodelist']->textContent);

		// print_r($row);die;

        return view('edit')->with('row', $row);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
    	$document = new \DomDocument('1.0');
		$document->load('data.xml');

		$xpath = new \DOMXpath($document);

        $delete = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="avatar"]');

        if(input::hasFile('avatar')) {
            $file = Input::file('avatar');
            $destinationPath = public_path().'/img';
            $filename = $file->getClientOriginalname();
            $fileXML = 'img/'.$filename;

            File::delete($delete['domnodelist']->textContent);  
            $file->move($destinationPath, $filename); 
        } else {
            $fileXML = null;
        }	 
        
        $requestData = $request->all();

        $name = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="name"]');
        $name['domnodelist']->nodeValue = $request['name'];

        $position = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="position"]');
        $position['domnodelist']->nodeValue = $request['position'];

		$city = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="city"]');
		$city['domnodelist']->nodeValue = $request['city'];

		$email = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="email"]');
		$email['domnodelist']->nodeValue = $request['email'];

		$department = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="department"]');
		$department['domnodelist']->nodeValue = $request['department'];

		$avatar = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="avatar"]');
		$avatar['domnodelist']->nodeValue = $fileXML;

		$status = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="status"]');
		$status['domnodelist']->nodeValue = $request['status'];

		$document->save('data.xml');	

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	/**
	    *
		* Using DomXML
		*
		*/
  		$document = new \DomDocument('1.0');
		$document->load('data.xml');

		$xpath = new \DOMXpath($document);

		// Use XPath to locate our node(s)
		$nodelist = $xpath->query('.//field[@name="id"][.='.$id.']/..');

		$avatar = $xpath->query('./row[field[@name="id"] ='.$id.']/field[@name="avatar"]');

		// Iterate over our node list and remove the data
		foreach ($nodelist as $dataNode) {
		    if ($dataNode->parentNode === null) {
		        continue;
		    }

		    // Get the data node parent (file) so we can call remove child
		    $dataNode->parentNode->removeChild($dataNode);
		}

		$document->save('data.xml');	

	   /**
	    *
		* Using SimpleXML
		*
		*/
		// $xml = new \SimpleXMLElement(file_get_contents('data.xml'));
		// $data = $xml->xpath('//field[@name="id"][.=' . $id . ']/..');

		// if (isset($data[0])) {
		//     unset($data[0]->{0});
		// }

		// $xml->asXML('data.xml');


		File::delete($avatar['domnodelist']->textContent);

        return redirect()->to('/');
    }
}