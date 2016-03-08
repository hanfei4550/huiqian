using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using DG.Tweening;

public class ActionBase
{
	public float stayTime = 0; //停留时间
	public List<TransPart> TransPartBox = new List<TransPart>();
	[HideInInspector]
	public int spriteCount = 0; //spr图片总数.
	//public List<PropertyPart> ProPropertyPartBox = new List<PropertyPart>();  //流程 属性
	/// <summary>
	/// 是否依赖txt文件中的记录,
	/// 用于判断是用 Initialization() 
	/// 还是 Initialization( List<TransPart> transPartList )初始化函数.	
	/// </summary>
	/// <returns><c>true</c>, if file was depended, <c>false</c> otherwise.</returns>
	virtual public bool DependFile()
	{
		return false;
	}
	/// <summary>
	/// 初始化<虚函数>
	/// </summary>
	virtual public void Initialization()
	{ }
	virtual public void Initialization( List<TransPart> transPartList )
	{ }
}

//*************************************************属性类*******************************************
/// <summary>
/// 流程 属性
/// </summary>
//public class PropertyPart
//{
//	public bool randomSprite = true; // 随机图片
//	public MaskType maskType = MaskType.Circle;  //遮罩
//}
/// <summary>
/// 基本变换信息,一个类对象表示一动画某部分
/// </summary>
[System.Serializable]
public class TransPart
{
	public Vector2 delayTime = Vector2.one;//延时
	public Vector2 transTime = Vector2.one;//过渡时间
	public Ease ease = Ease.Linear;//过渡效果
	[HideInInspector]
	public MaskType maskType = MaskType.Circle;  //遮罩
	[HideInInspector]
	public bool randomSprite = true; // 随机图片
	[HideInInspector]
	public bool isFaceForward = true;  //是否一直面向正前方
	[HideInInspector]
	public bool isShow = true;  //isShow 为 true 表示为sprite 此时用于显示,否则隐藏
	[HideInInspector]
	public List<Vector3> positionList = new List<Vector3>(); //位置
	[HideInInspector]
	public List<Vector3> rotationList = new List<Vector3>();//方向
	[HideInInspector]
	public List<float> scaleList = new List<float>();//大小
}



