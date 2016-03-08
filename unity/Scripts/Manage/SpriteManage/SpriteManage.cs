using UnityEngine;
using System.Collections;
using System.Collections.Generic;
public class SpriteManage : MonoBehaviour {
	[SerializeField]
	int spriteCount = 100;  					  			//场景图片总数
	string localSprPath = "Textures/LocalSprites";			//本地图片地址
	List<MySprite> spriteList = new List<MySprite>();
	List<GameObject> actionObjList = new List<GameObject>();
	GameObject manage = null;
	GameObject mDefaultObj = null;
	void Awake()
	{
		manage = GameObject.Find("Manage");
		mDefaultObj = GameObject.Find("defaultObj");
		CreatLocalSprite( spriteList );

		FindActionObjs();
		manage.BroadcastMessage("SetSpriteList",spriteList);
		manage.BroadcastMessage("SetActionObjList",actionObjList);
		MyTool.ASSERT(manage!=null && mDefaultObj!=null);
	}

	void Start () {
	
	}
	void Update()
	{
		UpdateSprFace();
		UpdateActionObj();
	}

	void UpdateSprFace()
	{
		//一直面向前方
		for( int i=0; i<spriteList.Count; i++ )
		{
			if( spriteList[i].isFaceForward == true || spriteList[i].sprite.transform.rotation == Quaternion.identity )
			{ continue; }
			//spriteList[i].sprite.transform.rotation = Quaternion.identity ;
		}
	}
	void UpdateActionObj()
	{
		for( int i=0; i<actionObjList.Count; i++ )
		{
			if(actionObjList[i].transform.childCount == 0 && actionObjList[i].transform.rotation != Quaternion.identity )
			{
				actionObjList[i].transform.rotation = Quaternion.identity;
			}
		}
	}
//	void UpdateSprite()
//	{
//		for( int i=0; i<spriteList.Count; i++ )
//		{
//			if(spriteList[i].isSport && spriteList[i].sprite.transform.parent  == mDefaultObj )
//			{
//
//			}
//		
//		}
//	}
//	GameObject GetFreeActionObj()
//	{
//		for(int i=0; i<actionObjList.Count; i++ )
//		{
//			if(actionObjList[i].transform.childCount == 0)
//			{
//				return actionObjList[i];
//			}
//		}
//		MyTool.ASSERT(false,"actionObj物体太少！");
//		return null;
//	}
	//查找actionObj物体
	void FindActionObjs()
	{
		// ------------查找运动载体----------------------------
		GameObject spriteBox = GameObject.Find("SpriteBox");
		for(int i =0; i<spriteBox.transform.childCount; i++ )
		{
			GameObject actObj = spriteBox.transform.GetChild(i).gameObject;
			if(actObj.name == "default" ){continue;}
			actionObjList.Add( actObj );
		}
		MyTool.ASSERT(actionObjList.Count != 0,"找不到 actionObj物体！");
	}
	/// <summary>
	/// Creats the local sprite.生成本地sprite图片,并保存到spriteList中。
	/// </summary>
	void CreatLocalSprite( List<MySprite> sprList )
	{
		GameObject sprTemplate = GameObject.Find("SprTemplate");
		Texture2D[] texture2Ds = Resources.LoadAll<Texture2D>(localSprPath);
		MyTool.ASSERT(sprTemplate!=null && texture2Ds.Length!=0);
		int index = 0;
		for(int i=0; i<spriteCount; i++)
		{
			MySprite mSprite = new MySprite();
			GameObject spr = (GameObject)Instantiate(sprTemplate,sprTemplate.transform.position,Quaternion.identity);
			spr.renderer.material.SetTexture("_Texture",texture2Ds[index]);
			mSprite.sprite = spr;
			mSprite.texture2D = texture2Ds[index];
			mSprite.spriteFrom = SpriteFrom.Local;

			sprList.Add(mSprite);
			spr.transform.parent = mDefaultObj.transform;
			spr.name = "spr";
			index++;
			if(index>=texture2Ds.Length)
			{ index = 0; }
		}
	}
}
