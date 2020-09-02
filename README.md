## 哈希表Tag组件

该Package可以为模型提供贴标签的行为。按照下面的步骤安装完Package后，只需要将 `CanBeTaged` Trait添加到Model模型中,User模型中加入`CanTag` Trait 即可.

## 安装说明

1. `composer.json`改动如下：
   在`repositories`中添加 vcs 类型远程仓库指向
   `http://code.haxibiao.cn/packages/haxibiao-tag`
2. 执行`composer require haxibiao/tag`
3. 执行`php artisan tag:install && composer dump`
4. 执行`php artisan migrate`
5. 完成

## 使用案例

``` php
class User extends \Illuminate\Database\Eloquent\Model
{
	use \Haxibiao\Tag\Traits\CanTag;
}
class Post extends \Illuminate\Database\Eloquent\Model
{
	use \Haxibiao\Tag\Traits\CanBeTaged;
}

// 创建模型的时候携带tags, 不要忘记把"tags"放到模型的$fillable数组中
$post = Post::create([
   'description' => '动态描述',
   'tags' => ['美女', '电影'], //如果标签不存在它们能自己创建
]);

// 添加标签,如果遇到相同的标签名会自动跳过
$post->tagByNames('风景');
$post->tagByNames('风景,旅游');
$post->tagByNames(['风景','旅游']);

$post->tagByIds([1,2,3]);// 数组中的数字为标签的ID

// 同步标签,同步成最新的标签关系
$post->retagByNames('风景');// 此时动态只与标签"风景"有关联
$post->retagByNames('风景,旅游'); // 此时动态只与标签['风景','旅游']有关联
$post->retagByNames(['风景','读书']);// 此时动态只与标签['风景','读书']有关联

$post->retagByIds([2,3]);// 此时动态只与标签[2,3]有关联,之前维系的标签关系都解除

// 解除标签关系
$post->untagByIds([1,2]);
$post->untagByNames(['风景','读书']);
$post->untagByNames('风景,读书');

// 其他辅助类的方法或属性
$post->countTags();// $post下有多少标签数量
$post->tagNames();// 以数组的形式返回当前模型的所有标签,如:['风景','读书']);
$post->tagNames;// 以字符串的形式返回当前模型的所有标签,如:'风景,读书'];

App\Tag::where('count', '>', 5)->get();// 取出关联数大于5的所有标签
```

## 如何完成扩展
如果某些项目对Tag有特殊的定制需求,只需要将代码放在`\App\Tag`中.
执行完`php artisan tag:install`后会发布:
- \App\Tag
- lightouse graphql schema
schema中只保存了基本的标签操作,支持新场景的拓展

## 更新日志
**1.0**

_Released on 2020-09-02_

添加了基本的增删查改功能

## 其他
如果发现问题或有新的需求可在群内一起交流.