<?php

namespace App\Http\Controllers;

use App\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
    {
        $this->middleware('auth')->only('create');
    }


    //دالة لعرض جميع المقالات
    public function index()
    {
//        $posts= $this->getAllPosts();
//        $posts=DB::table('posts')->latest()->get();
//        dd($posts);
        $posts = Post::latest()->get();
        $archives = $this->getArchives();
        return view('post.index', compact('posts', 'archives'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    //دالة لعرض المقالة برقم المعرف بحيث يسهل استعمالها مع المسار
    public function show($id)
    {
//نستخدم الدالة الي تحت في حال جلب البيانات من المصفوفة الترابطية وليس من قاعدة البيانات
//        $post = $this->getAllPosts()[$id];
//        $post = DB::table('posts')->find($id); //نستخدم هذه الدالة في حال جلب البيانات من قاعدة البيانات
        $post = Post::find($id);
        $archives = $this->getArchives();
        return view('post.show', compact('post', 'archives'));
    }


    public function create()
    {
        //
        $archives = $this->getArchives();
        $method='post';
        $action=route('posts.store');
        return view('post.create', compact('archives','method','action'));
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
//        dd($request->all()); to test the data
        //الطريقة الاولى لحفظ البيانات من الفورم الى السيرفر
//        $post = new Post();
//        $post->title = $request->title;
//        $post->body  = $request->body;
//        $post->excerpt = $request->excerpt;
//        $post->is_published = (bool)$request->is_published;
//        $post->user_id = $request->user_id;
//        $post->save();

        //نستخدم هذه الطريقة للتحقق من صحة البيانات
        $this->validate($request,[
           'title'      =>'required|max:150',
            'body'      =>'required',
            'excerpt'   =>'required'
        ],[
            'title.required' => 'ادخل اسم المقالة',
            'title.max' => 'لقد تجاوزت عدد الاحرف المسموح به'
        ]);

        Post::create([
            'title'=>$request->title,
            'body'=>$request->body,
            'excerpt'=>$request->excerpt,
            'is_published'=>(bool)$request->is_published,
            'user_id'=>$request->user_id
        ]);

        return redirect('/posts');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        //نعرف المتغيرين اكشن وميثود عشان يكونوا حسب نوعية الفورم ونعدلهم في صفحة العرض كمان
        $post = Post::find($id);
        $method='put';
        $action=route('posts.update',['post'=>$id]);
        $archives = $this->getArchives();
        return view('post.create',compact('post','archives','action','method'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Post::find($id)->update($request->all());

        return redirect('posts');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    // to get posts by specific year and month
    public function archive($year, $month)
    {
        $posts = Post::whereyear('created_at', $year)->wheremonth('created_at', $month)->get();
        $archives = $this->getArchives();
        return view('post.index', compact('posts', 'archives'));
    }


    private function getAllPosts()
    {
        return [
            1 => [
                'title' => 'المقالة الأولى',
                'body' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.',
                'author' => 'محمد',
                'created_at' => Carbon::createFromDate(2017, 8, 15)->diffForHumans()
            ],
            2 => [
                'title' => 'المقالة الثانية',
                'body' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.',
                'author' => 'عبدالله',
                'created_at' => Carbon::createFromDate(2020, 5, 1)->diffForHumans()
            ],
            3 => [
                'title' => 'المقالة الثالثة',
                'body' => 'هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد من النصوص الأخرى إضافة إلى زيادة عدد الحروف التى يولدها التطبيق.
إذا كنت تحتاج إلى عدد أكبر من الفقرات يتيح لك مولد النص العربى زيادة عدد الفقرات كما تريد، النص لن يبدو مقسما ولا يحوي أخطاء لغوية، مولد النص العربى مفيد لمصممي المواقع على وجه الخصوص، حيث يحتاج العميل فى كثير من الأحيان أن يطلع على صورة حقيقية لتصميم الموقع.',
                'author' => 'علي',
                'created_at' => Carbon::createFromDate(2019, 1, 20)->diffForHumans()
            ]
        ];
    }


    // to get all archives details
    private function getArchives()
    {
        return \App\Post::selectRaw('monthname(created_at) month, MONTH(created_at) month_number,
             YEAR(created_at) year, COUNT(*) posts_count')->groupBy('month', 'month_number', 'year')->orderBY('created_at')->get();

    }



}
