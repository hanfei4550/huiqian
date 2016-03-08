using UnityEngine;
using System.Collections;
using System.Collections.Generic;
using DG.Tweening;

public class UnitProcessBase : MonoBehaviour  {
	[SerializeField]
	float actionSize = 1; //大小
	//动作列表
	public List<ActionBase> actionList = new List<ActionBase>();
	protected List<GameObject> actionObjList = new List<GameObject>();//单体行为动作载体
	List<MySprite> spriteList = new List<MySprite>();//sprite图片列表
	List<MaskInfo> maskInfoLsit =new List<MaskInfo>(); //遮罩索引
	FileRecordACT theFileRecordACT = null;//获取文本记录
	GameObject defaultObj = null;  //spr过渡父物体
	GameObject parentActObj = null; //spr运动父物体
	int spriteCount = 0;//该单体sprite图总数
	float lastDelayTime = 0;//上一次延时
	//float surplusTime = 0;
	void Awake()
	{
		defaultObj = GameObject.Find("defaultObj");
		MyTool.ASSERT(defaultObj!=null);
	}
	//为spriteList赋值
	public void SetSpriteList(List<MySprite> sprList )
	{
		MyTool.ASSERT( sprList.Count!=0 );
		spriteList = sprList;
	}
	public void SetMaskInfoList( List<MaskInfo> maLsit )
	{
		MyTool.ASSERT( maLsit.Count!=0 );
		maskInfoLsit = maLsit;
	}
	public void SetActionObjList(List<GameObject> actObjList)
	{
		actionObjList = actObjList;
	}
	//设置sprite图片遮罩
	void SetSprMask( MySprite spr , MaskType mMask)
	{
		if( mMask == spr.maskType )
		{return;}
		spr.maskType = mMask;
		Texture2D maskTexture2D = null;
		for( int i = 0; i<maskInfoLsit.Count; i++)
		{
			if(mMask == maskInfoLsit[i].maskType)
			{
				maskTexture2D = maskInfoLsit[i].mask;
				break;
			}
			if( i == maskInfoLsit.Count-1 )
			{
				MyTool.ASSERT(false,"找不到该遮罩mask！");
				return;
			}
		}
		spr.sprite.renderer.material.SetTexture("_Mask",maskTexture2D);

	}
	//设置tag标签
	void SetSprTag(Transform spr,bool isFaceForward,string mTag)
	{
		if(isFaceForward)
		{
			spr.tag = mTag;
		}
	}

	void OnTweenStart(MySprite spr , MaskType mMask, bool isFaceForward,bool isShow, int indexOfActList)
	{

		if( isShow  )
		{
			SetSprParent( spr.sprite, parentActObj ) ;
			spr.isSport = true;
		}
		else
		{
			spr.isSport = false;
			SetSprParent(spr.sprite,defaultObj);
		}
		SetSprMask(spr,mMask);
//		if(isFaceForward)
//		{ spr.isFaceForward = true; }
//		else
//		{  spr.isFaceForward = false;   }
//******
//		if( indexOfActList == 0 )
//		{
//			 //SetSprMask(spr,mMask);
//			 SetSprTag(spr,isFaceForward, "faceForward" );
//			 //	SetSprParent(spr.gameObject,defaultObj);
//		}
//		else if( indexOfActList == 1 )
//		{
//			//SetSprParent( spr.gameObject, parentActObj ) ;
//		}
//******
		if(indexOfActList == actionList.Count-1 )
		{
			LastActionEnd(spr);
		}
		
		if( 0 == FinIndexOfSprList(spr))
		{ OnActStart(spr.sprite.transform, indexOfActList ); }
	}
	//用于子类继承
	virtual protected void OnActStart(Transform spr, int indexOfActList )
	{

	}
	//单体最后Tween 结束时回调函数
	void OnTweenEnd(MySprite spr , MaskType mMask, bool isFaceForward, int indexOfActList)
	{
		if( FinIndexOfSprList(spr) == spriteCount-1 )
		{
			OnActEnd(spr.sprite.transform, indexOfActList );
		}
	}
	//用于子类继承
	virtual protected void OnActEnd(Transform spr, int indexOfActList )
	{

	}
	void LastActionEnd(MySprite spr )
	{
		if( spr.isSport )
		{
			spr.isSport = false;
		}
		SetSprParent(spr.sprite,defaultObj);
	}
	GameObject GetFreeActionObj()
	{
		for(int i=0; i<actionObjList.Count; i++ )
		{
			if(actionObjList[i].transform.childCount == 0)
			{
				return actionObjList[i];
			}
		}
		MyTool.ASSERT(false,"actionObj物体太少！");
		return null;
	}
	void SetSprParent(GameObject spr, GameObject obj)
	{
		spr.transform.parent = obj.transform;
	}
	//查找List列表中元素索引
	int FinIndexOfSprList(MySprite element )
	{
		for(int i=0; i<spriteList.Count; i++ )
		{
			if( element == spriteList[i])
			{
				return i;
			}
		}
		MyTool.ASSERT(false,"找不到该物体！");
		return -1;
	}
	/// <summary>
	/// 将动作加入到单体中.
	/// </summary>
	/// <param name="act">Act.</param>
	public void AddToActionList(ActionBase act)
	{
		actionList.Add(act);
		//DependFile == false 表示不依赖文本的先初始化
		if( act.DependFile() == false )
		{
			act.Initialization();

			this.spriteCount = act.spriteCount;
		}
	
		if(act.ToString() == "FileRecordACT")
		{
			FileRecordACT mFileRecordACT =  (FileRecordACT)act;
			if( theFileRecordACT!=null )
			{
				int a = mFileRecordACT.TransPartBox.Count ;
				int b = theFileRecordACT.TransPartBox.Count ;
				MyTool.ASSERT( a == b,"该单体含有多个txt记录文件,且记录actionObj数量不相等！" );
			}
			theFileRecordACT = mFileRecordACT;
		}
	
	}
	virtual public void Initialization()
	{
		MyTool.ASSERT(theFileRecordACT!=null);
		for(int i =0; i<actionList.Count; i++ )
		{
			//依赖文本的后初始化
			if( actionList[i].DependFile()  )
			{
				actionList[i].Initialization( theFileRecordACT.TransPartBox );
			}
		}
	}
	/// <summary>
	/// 将动作插入到 动作 类之前
	/// </summary>
	/// <param name="sequence">Sequence.</param>
	/// <param name="typeName">Type name.</param>
	virtual public void AppendToBefore( Sequence sequence, int indexOfActList )
	{

	}
	/// <summary>
	/// 在某个动作时加入该动作
	/// </summary>
	/// <param name="sequence">Sequence.</param>
	/// <param name="typeName">Type name.</param>
	virtual public void JoinToSeqInTheAct(Sequence sequence, int indexOfActList )
	{

	}
	//引进Sequence 顺序.
	public void BringInSequence(Sequence sequence)
	{
		SequenceForUnit ( sequence );
	}
	//public void 
	/// <summary>
	/// 操作单体
	/// <将单体流程添加到Sequence 顺序中. 参数 uPro ： 单体流程>
	/// </summary>
	/// <param name="uPro">U pro.</param>
	void SequenceForUnit (Sequence sequence ) 
	{
		//MyTool.ASSERT(BuildInProcessList.Count<=actionObjList.Count,"actionObj物体数量过少！");
		
		for( int i=0; i<actionList.Count; i++ )
		{
			//单体核心,流程信息记录
			ActionBase action = actionList[i]; 
			//注意：顺序
			AppendToBefore( sequence, i);//用于扩展

			SequenceForActProcess(sequence,action,i);

			JoinToSeqInTheAct( sequence, i);//用于扩展

			sequence.AppendInterval(action.stayTime);//单个动画停留时间设置
		}
	}
	/// <summary>
	/// 操作单体内部单个动画流程.
	/// </summary>
	/// <param name="seq">Seq.</param>
	/// <param name="aBuildInPro">A build in pro.</param>
	/// <param name="index">Index.</param>
	void SequenceForActProcess (Sequence seq,ActionBase anAct, int indexOfActList )
	{
		//spr图片索引.
		int indexOfSpr = 0;
		for(int i=0; i<anAct.TransPartBox.Count; i++)
		{
//			GameObject parentActObj = null;
//			//内部单个流程第一个流程才需要为sprite图设置父物体.
//			if( indexOfActList == 0 )
//			{  parentActObj = GetFreeActionObj();  }
			parentActObj = GetFreeActionObj();
			SequenceForPart(seq,anAct.TransPartBox[i],ref indexOfSpr,indexOfActList);
		}
	}
	/// <summary>
	///动画单个部件
	/// </summary>
	void SequenceForPart(Sequence seq,TransPart transPart,ref int indexOfSpr,int indexOfActList )
	{
		Vector3 point = Vector3.zero;
		Vector3 rota = Vector3.zero;

		for( int i= 0;i<transPart.positionList.Count; i++ )
		{ 
			//获取图片
			MySprite spr = spriteList[indexOfSpr];
			spr.isFaceForward = transPart.isFaceForward;
			//当act载体物体为空，表示该次不需要设置父物体.
//			if(parentActObj!=null && indexOfActList == 1 )
//			{spr.parent = parentActObj.transform;}

			//每个单体第一个sprite 图动作 进行Append，其余 Join到顺序 中.
			point = transPart.positionList[i]*actionSize;
			rota = transPart.rotationList[i];

			float delayTime = Random.Range(transPart.delayTime.x,transPart.delayTime.y);
			float tansTime = Random.Range(transPart.transTime.x,transPart.transTime.y);

			if(indexOfSpr ==0)
			{
				lastDelayTime = 0;
				seq.Append( SpriteDOMove( spr, point, transPart, delayTime, tansTime, indexOfActList) );
			}
			else
			{ 
				seq.Join( SpriteDOMove( spr, point, transPart, delayTime, tansTime, indexOfActList ) );
			}
			//if(rota!=Vector3.zero)
			seq.Join( SpriteDORota( spr, rota, transPart, 0, tansTime,indexOfActList ) );
			indexOfSpr++;
 			MyTool.ASSERT(indexOfSpr<spriteList.Count,"Sprite图片数量设置过少！");

		}
	}
	Tween SpriteDOMove( MySprite spr, Vector3 point , TransPart transPart ,float delayTime,float tansTime,int indexOfActList  )
	{

		Tween mTween = spr.sprite.transform.DOLocalMove( point,tansTime,false);
		mTween.SetDelay(delayTime-lastDelayTime);
		mTween.SetEase(transPart.ease);
		lastDelayTime = delayTime;
		mTween.SetEase(transPart.ease);
		mTween.OnStart( ()=>OnTweenStart( spr, transPart.maskType, transPart.isFaceForward ,transPart.isShow ,indexOfActList ) );
		mTween.OnComplete( ()=>OnTweenEnd( spr, transPart.maskType, transPart.isFaceForward ,indexOfActList ) );
		return mTween;
	}
	Tween  SpriteDORota( MySprite spr, Vector3 rota , TransPart transPart ,float delayTime,float tansTime,int indexOfActList )
	{
//		if(indexOfActList == 2)
//		{
//			int a = 0;
//		}
		Tween mTween = spr.sprite.transform.DOLocalRotate( rota,tansTime,0 );
		mTween.SetEase(transPart.ease);
		//mTween.SetDelay(delayTime);
		return mTween;
	}

}
