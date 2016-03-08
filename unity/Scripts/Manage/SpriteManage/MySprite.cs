using UnityEngine;
using System.Collections;
///Sprite属性
public class MySprite
{
	public Texture2D  texture2D = null; //图片
	public GameObject sprite = null;  //sprite物体
	public MaskType maskType = MaskType.Circle;  //遮罩类型
	public SpriteFrom spriteFrom = SpriteFrom.Local; //图片来源
	public bool isSport = false;             //是否在运动
	public bool isFaceForward = true;        //是否面向前方

}

/// 图片来源
public enum SpriteFrom
{
	/// 本地
	Local,
	/// 用户
	User
}